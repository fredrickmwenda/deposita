<?php

namespace App\Http\Controllers;

use App\Models\Attendant;
use App\Models\Recovery;
use App\Models\transaction;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    /**
     * Display a listing of the resource of Shorts and Gains
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the total difference across all transactions
        
    
        // Get the selected year from the request, defaulting to the current year
        $selectedYear = $request->input('year', date('Y'));

        $totalDifference = transaction::whereYear('created_at', $selectedYear)->sum('difference');
    
        // Get all attendants with their associated transactions filtered by the selected year
        $attendants = Attendant::with(['transactions' => function ($query) use ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }])->get();
    
        // Initialize an array to store the sum of differences for each attendant
        $attendantSumDifference = [];
    
        // Iterate through each attendant
        foreach ($attendants as $attendant) {
            // Calculate the sum of differences for the current attendant
            $sumDifference = $attendant->transactions->sum('difference');
    
            // Store the sum of differences for the current attendant
            $attendantSumDifference[$attendant->id] = $sumDifference;
        }
    
        return view('differences.all', [
            'totalDifference' => $totalDifference,
            'attendants' => $attendants,
            'attendantSumDifference' => $attendantSumDifference,
            'selectedYear' => $selectedYear, // Pass the selected year to the view
        ]);
    }

    public function showAttendantDifferences(Request $request, $attendantId)
    {
        // Retrieve the attendant based on the attendantId
        $attendant = Attendant::findOrFail($attendantId);

        // Retrieve the transactions for the attendant
        $transactions = $attendant->transactions;

        return view('differences.attendant', [
            'attendant' => $attendant,
            'transactions' => $transactions,
        ]);
    }

    public function showAttendantCashierRecord(Request $request, $recordId){
        $transaction = transaction::where('id', $recordId)->first();

        return view('differences.cashier_record', compact('transaction'));
    } 


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function show(Recovery $recovery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function edit(Recovery $recovery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recovery $recovery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recovery $recovery)
    {
        //
    }
}
