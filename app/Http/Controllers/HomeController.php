<?php

namespace App\Http\Controllers;

use App\Models\Attendant;
use App\Models\DataStorage;
use App\Models\Recovery;
use App\Models\transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = User::count();
        $attendantsi = Attendant::count();
        $drops = DataStorage::count();
        $difference = transaction::whereYear('created_at', Carbon::now()->year)->sum('difference');

        // Retrieve all attendants andtheir transactions
        $attendants = Attendant::with('transactions')->get();
        //dd($attendants);

        // Calculate performance for each attendant
        foreach ($attendants as $attendant) {
            $transactions = $attendant->transactions;

            if ($transactions->isNotEmpty()) {
                // Summing up transactions and recoveries
                $totalExpected = $transactions->sum('expected');
                $total = $transactions->sum('total');

                // Summing up recovery amounts through transactions
                $recovery = $transactions->sum(function ($transaction) {
                    return is_numeric($transaction->recovery) ? (float)$transaction->recovery : 0;
                });

                // Avoid division by zero error
                if ($totalExpected != 0) {
                    $performance = intval(($total + $recovery) / $totalExpected * 100);
                } else {
                    $performance = 0;
                }

                // Store performance for each attendant with Card_name as the key
                $attendantsPerformance[$attendant->Card_name] = $performance;
            } else {
                // Handle case where there are no transactions for the attendant
                $attendantsPerformance[$attendant->Card_name] = 0;
            }
        }

        // Rank the attendants based on performance (descending order)
        arsort($attendantsPerformance);

        // Get the top three performers
        $topThreePerformers = array_slice($attendantsPerformance, 0, 3, true);

        // dd($topThreePerformers);

        $graphDataResponse = $this->graphData(request());

        // Extract the graph data from the response
        $graphData = $graphDataResponse->getData()->graphData;
        //dd($graphData);



        return view('dashboard', compact('users', 'attendantsi', 'drops', 'difference', 'topThreePerformers', 'graphData'));
    }






    public function graphData(Request $request)
    {
        // Default time interval is a month
        $interval = $request->input('interval', 'month');

        // Default start and end dates for the current month
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        // Adjust the start and end dates based on the selected interval
        switch ($interval) {
            case 'day':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'year':
                $startDate = now()->subYear(10)->startOfYear(); // 10 years back, starting from the beginning of the year
                $endDate = now()->endOfYear();
                break;
                // Default case: 'month' (no need to change the dates)
        }

        // Fetch transactions and recoveries based on the selected time interval
        $transactions = transaction::whereBetween('created_at', [$startDate, $endDate])->get();
        $recoveries = Recovery::whereBetween('created_at', [$startDate, $endDate])->get();

        // Group transactions based on the selected interval
        $groupedTransactions = $transactions->groupBy(function ($transaction) use ($interval) {
            switch ($interval) {
                case 'day':
                    return $transaction->created_at->format('Y-m-d'); // Group by day
                case 'month':
                    return $transaction->created_at->format('M'); // Group by month
                case 'year':
                    return $transaction->created_at->format('Y'); // Group by year
            }
        });

        // Group recoveries based on the selected interval
        $groupedRecoveries = $recoveries->groupBy(function ($recovery) use ($interval) {
            switch ($interval) {
                case 'day':
                    return $recovery->created_at->format('Y-m-d'); // Group by day
                case 'month':
                    return $recovery->created_at->format('M'); // Group by month
                case 'year':
                    return $recovery->created_at->format('Y'); // Group by year
            }
        });

        // Prepare the data for graph display
        $graphData = [
            'transactionData' => [],
            'recoveryData' => [],
        ];

        // Process transactions data
        $this->processGroupedData($groupedTransactions, $interval, $graphData['transactionData']);

        // Process recoveries data
        $this->processGroupedData($groupedRecoveries, $interval, $graphData['recoveryData']);

        // Example: return the graph data as JSON
        return response()->json(['graphData' => $graphData]);
    }

    public function getShortGainData(Request $request)
    {
        $selectedYearDifference = Transaction::whereYear('created_at', $request->year)->sum('difference');
        return response()->json(['shortGain' => $selectedYearDifference]);
    }

    private function processGroupedData($groupedData, $interval, &$result)
    {
        $allIntervals = [];

        // Generate all possible intervals based on the selected interval type
        if ($interval === 'day') {
            $allIntervals = range(now()->startOfDay(), now()->endOfDay(), new \DateInterval('P1D'));
        } elseif ($interval === 'month') {
            $allIntervals = collect(range(1, 12))->map(function ($month) {
                return now()->month($month)->startOfMonth();
            });
        } elseif ($interval === 'year') {
            $allIntervals = range(now()->subYear(10)->startOfYear(), now()->endOfYear(), new \DateInterval('P1Y'));
        }

        // Iterate through all possible intervals and set count to 0 if not present in the grouped data
        foreach ($allIntervals as $currentInterval) {
            $formattedKey = $currentInterval->format($this->getDateFormat($interval));
            $result[$interval][$formattedKey] = $groupedData->has($formattedKey) ? $groupedData[$formattedKey]->count() : 0;
        }
    }

    private function getDateFormat($interval)
    {
        switch ($interval) {
            case 'day':
                return 'Y-m-d';
            case 'month':
                return 'M';
            case 'year':
                return 'Y';
        }
    }
}
