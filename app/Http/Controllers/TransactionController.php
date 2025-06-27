<?php

namespace App\Http\Controllers;

use App\Models\Attendant;
use App\Models\Coin;
use App\Models\DataStorage;
use App\Models\Recovery;
use App\Models\transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transactions.index', [
            'transactions' => transaction::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attendants = Attendant::orderBy('name', 'asc')->get();
        return view('transactions.create', compact('attendants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Make sure to import the Transaction model if not already done

    public function store(Request $request)
    {
        try {
            // Retrieve the transactions data from the request
            $transactionsData = $request->input('transactions');
            Log::info($transactionsData);

            // Loop through each transaction and save it to the database
            $exist_data = [];
            foreach ($transactionsData as $transactionData) {
                try {
                    // check also where the shift aint the same for the same day
                    $existingTransaction = Transaction::where('date', $transactionData['date'])
                        ->where('attendant_id', $transactionData['attendant_id'])
                        ->where('shift', $transactionData['shift'])
                        ->first();
                    //set $existing as +1 and array push to exist_data
                    if ($existingTransaction) {
                        $existingTransaction->count += 1;
                        $exist_data[] = $existingTransaction;

                        continue; // Skip this transaction if it already exists
                    }

                    // Handle the case where 'cash' key is missing or not set
                    if (!isset($transactionData['cash'])) {
                        info('no cash present');
                        $transactionData['cash'] = 0;
                    }

                    $difference = str_replace(',', '', $transactionData['difference']);
                    //convert to a float value
                    $dif_float = floatval($difference);
                    $isDifferenceValidFloat = !is_nan($dif_float);

                    if ($isDifferenceValidFloat) {
                        $transaction = new Transaction();
                        $transaction->attendant_id = $transactionData['attendant_id'];
                        $transaction->date = $transactionData['date'];
                        $transaction->total = str_replace(',', '', $transactionData['total_drop']); // remove commas from total
                        $transaction->expected = $transactionData['expected'];
                        $transaction->difference = $dif_float;
                        $transaction->coins = $transactionData['total_coins'];
                        $transaction->cash = $transactionData['cash'];
                        if ($transactionData['shift'] == 'Night') {
                            $transaction->shift = 'night';
                        } else {
                            $transaction->shift = 'day';
                        }
                        if (isset($transactionData['comment'])) {
                            $transaction->comment = $transactionData['comment'];
                        }

                        $transaction->save();
                    } else {
                        return response()->json([
                            'success' => true,
                            'message' => 'Difference has Nan Value fix it first',
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing transaction: ' . $e->getMessage());

                    // Return an error response to the client-side
                    return response()->json([
                        'success' => false,
                        'message' => 'An error occurred while processing transactions.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            $responseMessage = 'Transactions saved successfully.';
            if (count($exist_data) > 0) {
                $responseMessage = 'Some transactions already exist, please check the cashier record list.';
            }

            // Combine the success status and existing_transactions data (if any)
            $responseData = [
                'success' => true,
                'message' => $responseMessage,
                'existing_transactions' => $exist_data
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error saving transactions: ' . $e->getMessage());

            // Return an error response to the client-side
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving transactions.',
                'error' => $e->getMessage() // Include the specific error message in the response
            ], 500); // Use 500 for internal server error status code
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $attendants = Attendant::all();
        $transaction = transaction::where('id', $id)->first();
        return view('transactions.edit', [
            'transaction' => $transaction, 'attendants' => $attendants
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request+++++++++++++++
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $request->validate([
            'date' => 'required',
            'total' => 'required',
            'expected' => 'required',
            'difference' => 'required',
        ]);
        // Find the transaction by ID
        $transaction = Transaction::find($id);

        // Update the fields from the request
        $transaction->coins = $request->coins ?? $transaction->coins;
        $transaction->cash = str_replace(',', '', $request->cash) ??  $transaction->cash;
        $transaction->expected = str_replace(',', '', $request->expected);
        $transaction->difference = str_replace(',', '', $request->difference);
        $transaction->comment = $request->comment ?? '';

        // Get the existing recovery amount and add it to the new recovery amount from the request


        // Save the updated transaction record
        $transaction->save();
        //   return to transactions create page
        return redirect()->route('storage.list')->with('success', 'Transaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction $transaction)
    {
        //
    }

    //getAttendants function
    public function getAttendants(Request $request)
    {
        if ($request->ajax()) {
            // check that data  from ajax has shift and date
            $shift = $request->input('shift');
            $date = $request->input('date');
            Log::info($date);


            $attendeeId = $request->input('attendeeId');

            if (!isset($shift) || !isset($date) || !isset($attendeeId)) {
                return response()->json([]);
            }

            if ($shift == 1) {
                Log::info('night shift');
                Log::info($shift);
                // list($startDay, $endDay) = explode(',', $date);

                $startDate = Carbon::createFromFormat('Y-m-d H:i', $date . ' 14:00');

                //add 1day to the date
                // $startDate = Carbon::createFromFormat('Y-m-d', $date);
                //$endDate = $startDate->copy()->addDay();
                $endDate = $startDate->copy()->addDay()->setTime(14, 0);
                // Log::info($endDate);
                $startDateString = $startDate->format('d/m/Y H:i');
                $endDateString = $endDate->format('d/m/Y H:i');
                Log::info($startDateString);
                Log::info($endDateString);


                if (!$startDate || !$endDate) {
                    return response()->json([]);
                }

                $total_datas = DataStorage::where('Card_id', $attendeeId)
                    ->where('shift', $shift)
                    ->where(function ($query) use ($startDateString, $endDateString) {
                        $query->whereRaw("STR_TO_DATE(DateTime, '%d/%m/%Y %H:%i') >= STR_TO_DATE('$startDateString', '%d/%m/%Y %H:%i')")->whereRaw("STR_TO_DATE(DateTime, '%d/%m/%Y %H:%i') <= STR_TO_DATE('$endDateString', '%d/%m/%Y %H:%i')");
                    })
                    ->get();
            } else {
                $date = Carbon::createFromFormat('Y-m-d', $date);
                $formattedDate = $date->format('d/m/Y');
                Log::info($formattedDate);
                $total_datas = DataStorage::where('Card_id', $attendeeId)->where('shift', $shift)->where('DateTime', 'like', $formattedDate . '%')->get();
            }

            $total = 0;

            // Loop through the attendances and convert each Total string to a float before adding it to the sum
            foreach ($total_datas  as $attendance) {
                $total += (float) $attendance->Total;
            }
            Log::info($total);

            return $total;
        }
    }







    public function showDataStorage(Request $request, $attendantId, $shift, $date)
    {

        //if the shift is night then it 1 else 0

        $shift = $shift == 'night' ? 1 : 0;
        $date = Carbon::createFromFormat('Y-m-d', $date);
        //dd($attendantId, $shift, $date);
        // Get all datastorages for the attendant in the specified shift and date
        $dataStorages = DataStorage::where('Card_id', $attendantId)
            ->where('shift', $shift)
            ->whereDate('DateTime', $date->format('m-d-Y'))
            ->get();
        //dd($dataStorages);

        // Initialize a variable to hold the sum
        $totalSum = 0;

        // Loop through the datastorages and convert each Total string to a float before adding it to the sum
        foreach ($dataStorages as $dataStorage) {
            $totalSum += (float) $dataStorage->Total;
        }

        // Return the view with the datastorages and the total sum
        return view('data.show', [
            'dataStorages' => $dataStorages,
            'totalSum' => $totalSum
        ]);
    }
    //opens a page with the drops of the attendant
    //    public function showAttendantDrops(Request $request, $attendantId)
    //    {

    //        $dataStorages = DataStorage::where('Card_id', $attendantId)->get();
    //        $totalSum = 0;

    //        $attendant = Attendant::find($attendantId);
    //        $attendant = $attendant->name;


    //        // Loop through the datastorages and convert each Total string to a float before adding it to the sum
    //        foreach ($dataStorages as $dataStorage) {
    //            $totalSum += (float) $dataStorage->Total;
    //        }

    //        // Return the view with the datastorages and the total sum
    //        return view('transactions.show', [
    //            'dataStorages' => $dataStorages,
    //            'totalSum' => $totalSum,
    //            'attendant' => $attendant
    //        ]);
    //    }

    public function showAttendantDrops(Request $request, $attendantId, $TransactionDate)
    {
        // Convert the TransactionDate format from "2024-03-21" to "21/03/2024"
        $transactionDateFormatted = Carbon::createFromFormat('Y-m-d', $TransactionDate)->format('d/m/Y');
        // dd($transactionDateFormatted);
        // Filter DataStorage records by Card_id and DateTime
        $dataStorages = DataStorage::where('Card_id', $attendantId)
            ->where('DateTime', 'like', $transactionDateFormatted . '%')->get();

        $totalSum = 0;

        $attendant = Attendant::find($attendantId);
        $attendant = $attendant->name;

        // Loop through the datastorages and convert each Total string to a float before adding it to the sum
        foreach ($dataStorages as $dataStorage) {
            $totalSum += (float) $dataStorage->Total;
        }

        // Return the view with the datastorages and the total sum
        return view('transactions.show', [
            'dataStorages' => $dataStorages,
            'totalSum' => $totalSum,
            'attendant' => $attendant
        ]);
    }

    public function showRecoveries(Request $request, $transaction_id)
    {

        $recoveries = Recovery::where('transaction_id', $transaction_id)->get();
        $totalSum = 0;


        //use the transaction_id to get the attend since a Transaction belongs to a n attendant
        $transaction  = Transaction::where('id', $transaction_id)->first();


        $attendant = Attendant::find($transaction->attendant_id);
        $attendant = $attendant->name;


        // Loop through the datastorages and convert each Total string to a float before adding it to the sum
        foreach ($recoveries as $dataStorage) {
            $totalSum += (float) $dataStorage->recovery_amount;
        }

        // Return the view with the datastorages and the total sum
        return view('recoveries.show', [
            'recoveries' => $recoveries,
            'totalSum' => $totalSum,
            'attendant' => $attendant
        ]);
    }

    public function delete($id)
    {
        $transaction = transaction::findOrFail($id);
        $transaction->coins()->delete();
        $transaction->recoveries()->delete();
        $transaction->delete();

        return redirect()->route('storage.list')->with('success', 'Transaction deleted successfully');
    }

    public function massDeleteRecords(Request $request)
    {
        $ids = $request->ids;

        try {
            $transactions = transaction::whereIn('id', $ids)->get();
            $transactions->each->delete();
            //transaction::whereIn('id', $ids)->delete(); //assuming Drop is the model for the drops
            $response = [
                'success' => true,
                'message' => 'Transactions successfully deleted.'
            ];
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'error' => [
                    'message' => 'Error deleting drops.',
                    'details' => $e->getMessage()
                ]
            ];
        }

        return response()->json($response);
    }

    // public function addCoin(Request $request, $id){
    //     //dd($id, $request->all());
    //     $validated = $request->validate([
    //         'coin_amount' => 'required|numeric|min:0',
    //     ]);
    //     $transaction = transaction::findorfail($id);
    //     $transaction->difference = $transaction->difference +  $request->coin_amount;
    //     $transaction->save();
    //     $coin = new Coin();
    //     $coin->transaction_id = $id;
    //     $coin->coin_amount = $request->coin_amount;
    //     $coin->save();
    //     //update the transaction difference by adding the coin amount to it


    //     return redirect()->route('storage.list')->with('success', 'Coin added successfully.');

    // }

    public function addRecovery(Request $request, $id)
    {
        //dd($id, $request->all());
        $validated = $request->validate([
            'recovery_amount' => 'required|numeric',
        ]);
        $transaction = transaction::findorfail($id);
        $transaction->difference = $transaction->difference +  $request->recovery_amount;
        $transaction->comment = $request->comment ?? $transaction->comment;
        $transaction->save();
        $recovery = new Recovery();
        $recovery->transaction_id = $id;
        $recovery->recovery_amount = $request->recovery_amount;
        $recovery->save();
        return redirect()->route('storage.list')->with('success', 'Recovery added successfully.');
    }
}
