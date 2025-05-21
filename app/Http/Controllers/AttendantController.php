<?php

namespace App\Http\Controllers;

use App\Models\Attendant;
use Illuminate\Http\Request;

class AttendantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role === 'provider') {
            $attendants = Attendant::all();
        } else {
            $attendants = Attendant::where('client_id', auth()->user()->client_id)->get();
        }
        return view('attendant.index', compact('attendants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Card_name'=>'required',
            'Card_number'=> 'required|unique:attendants'
        ]);

        Attendant::create([
            'Card_name' => $request->Card_name,
            'Card_number' => $request->Card_number,
            'client_id' => auth()->user()->client_id
        ]);
        

        return redirect()->route('attendant.index')->with('message', 'Attendant Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendant  $attendant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendant = Attendant::findOrFail($id);
        return response()->json(['card_name' => $attendant->Card_name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendant  $attendant
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $attendant = Attendant::where('id', $id)->first();
        return view('attendant.edit', compact('attendant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendant  $attendant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Card_name'=>'required',
            'Card_number'=> 'required|unique:attendants,Card_number,'.$id
        ]);

        $attendant = Attendant::where('id', $id)
            ->where('client_id', auth()->user()->client_id)
            ->firstOrFail();
        $attendant->Card_name = $request->Card_name;
        $attendant->Card_number = $request->Card_number;
        $attendant->save();

        return redirect()->route('attendant.index')->with('message', 'Attendant Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendant  $attendant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendant $attendant)
    {
        //
    }


    public function attendantPerformance(){
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
        //dd($attendantsPerformance);
        return view('attendant.performance', compact('attendantsPerformance'));

    }
}
