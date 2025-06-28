<?php

namespace App\Http\Controllers;

use App\Models\transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShortGainStatsController extends Controller
{
    public function getStats(Request $request)
    {
        $type = $request->input('type', 'year');
        $period = $request->input('period');
        info("Fetching stats for type: $type, period: $period");

        $response = [];
        
         try {
            switch($type) {
                case 'year':
                    $response['monthlyData'] = $this->getYearlyStats($period);
                    break;
                case 'month':
                    $response['dailyData'] = $this->getMonthlyStats($period);
                    break;
                case 'week':
                    $response['weeklyData'] = $this->getWeeklyStats($period);
                    break;
                case 'day':
                    $response['shiftData'] = $this->getDailyStats($period);
                    break;
            }

            $response['attendants'] = $this->getAttendantsData($type, $period);
            
            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Stats error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while fetching stats',
                'debug_message' => $e->getMessage()
            ], 500);
        }
    }

    private function getYearlyStats($year)
    {
        $data = transaction::whereRaw('YEAR(STR_TO_DATE(date, "%Y-%m-%d")) = ?', [$year])
            ->selectRaw('MONTH(STR_TO_DATE(date, "%Y-%m-%d")) as month, SUM(difference) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyData = array_fill(0, 12, 0); // Initialize array with 12 zeros
        foreach ($data as $record) {
            $monthlyData[$record->month - 1] = (float)$record->total;
        }

        return $monthlyData;
    }

    private function getMonthlyStats($period)
    {
        list($year, $month) = explode('-', $period);
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        $data = transaction::whereRaw('YEAR(STR_TO_DATE(date, "%Y-%m-%d")) = ? AND MONTH(STR_TO_DATE(date, "%Y-%m-%d")) = ?', [$year, $month])
            ->selectRaw('DAY(STR_TO_DATE(date, "%Y-%m-%d")) as day, SUM(difference) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $dailyData = array_fill(0, $daysInMonth, 0);
        foreach ($data as $record) {
            $dailyData[$record->day - 1] = (float)$record->total;
        }

        return $dailyData;
    }

    private function getWeeklyStats($period)
    {
        list($year, $week) = explode('-W', $period);
        $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek()->format('Y-m-d');
        $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek()->format('Y-m-d');

        $data = transaction::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('DAYOFWEEK(STR_TO_DATE(date, "%Y-%m-%d")) as day, SUM(difference) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $weeklyData = array_fill(0, 7, 0);
        foreach ($data as $record) {
            $weeklyData[$record->day - 1] = (float)$record->total;
        }

        return $weeklyData;
    }

    private function getDailyStats($date)
    {
            $yesterday = \Carbon\Carbon::parse($date)->subDay()->toDateString();
        $data = transaction::where('date', $date)
            ->selectRaw('shift, SUM(difference) as total')
            ->groupBy('shift')
            ->get();

        $shiftData = ['day' => 0, 'night' => 0];
        foreach ($data as $record) {
            $shiftData[$record->shift] = (float)$record->total;
        }

        return array_values($shiftData);
    }

        private function getAttendantPerformance($startDate, $endDate)
    {
        return \App\Models\transaction::with('attendant')
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->selectRaw('attendant_id, SUM(difference) as total_difference, SUM(ABS(difference)) as absolute_difference')
            ->groupBy('attendant_id')
            ->orderBy('absolute_difference', 'desc')  // Order by absolute value to show highest impact
            ->get()
            ->filter(function($transaction) {
                // Filter out any transactions without attendant info
                return $transaction->attendant && $transaction->attendant->name;
            })
            ->map(function($transaction) {
                return [
                    'name' => $transaction->attendant->name,
                    'difference' => (float)$transaction->total_difference,
                    'absolute_difference' => (float)$transaction->absolute_difference
                ];
            });
    }

    // private function getAttendantPerformance($startDate, $endDate)
    // {
    //     $transactions = \App\Models\transaction::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get();
    //     $attendantStats = [];
    //     foreach ($transactions as $transaction) {
    //         $assignment = \App\Models\CardAssignment::where('card_id', $transaction->card_id)
    //             ->where('assigned_from', '<=', $transaction->created_at)
    //             ->where(function($q) use ($transaction) {
    //                 $q->whereNull('assigned_to')
    //                   ->orWhere('assigned_to', '>=', $transaction->created_at);
    //             })
    //             ->first();
    //         $attendantName = $assignment && $assignment->attendant ? $assignment->attendant->name : null;
    //         if ($attendantName) {
    //             if (!isset($attendantStats[$attendantName])) {
    //                 $attendantStats[$attendantName] = [
    //                     'name' => $attendantName,
    //                     'difference' => 0,
    //                     'absolute_difference' => 0
    //                 ];
    //             }
    //             $attendantStats[$attendantName]['difference'] += (float)$transaction->difference;
    //             $attendantStats[$attendantName]['absolute_difference'] += abs((float)$transaction->difference);
    //         }
    //     }
    //     // Sort by absolute_difference descending
    //     usort($attendantStats, function($a, $b) {
    //         return $b['absolute_difference'] <=> $a['absolute_difference'];
    //     });
    //     return collect($attendantStats);
    // }

    private function getAttendantsData($type, $period)
    {
        $startDate = null;
        $endDate = null;

        switch($type) {
            case 'year':
                $startDate = Carbon::createFromFormat('Y', $period)->startOfYear();
                $endDate = Carbon::createFromFormat('Y', $period)->endOfYear();
                break;
            case 'month':
                list($year, $month) = explode('-', $period);
                $startDate = Carbon::createFromFormat('Y-m', "$year-$month")->startOfMonth();
                $endDate = Carbon::createFromFormat('Y-m', "$year-$month")->endOfMonth();
                break;
            case 'week':
                list($year, $week) = explode('-W', $period);
                $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek();
                $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek();
                break;
            case 'day':
                $startDate = Carbon::createFromFormat('Y-m-d', $period)->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $period)->endOfDay();
                break;
        }

        return $this->getAttendantPerformance($startDate, $endDate);
    }
}
