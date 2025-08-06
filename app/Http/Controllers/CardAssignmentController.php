<?php

namespace App\Http\Controllers;

use App\Models\CardAssignment;
use App\Models\Card;
use App\Models\Attendant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CardAssignmentController extends Controller
{
    public function index()
    {
        $assignments = CardAssignment::with(['attendant', 'card'])->orderByDesc('assigned_from')->get();
        return view('card_assignment.index', compact('assignments'));
    }

    public function create()
    {
        $attendants = Attendant::all();
        $cards = Card::all();
        return view('card_assignment.create', compact('attendants', 'cards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendant_id' => 'required|exists:attendants,id',
            'card_id' => 'required|exists:cards,id',
        ]);
        // End any current assignment for this card
        CardAssignment::where('card_id', $request->card_id)
            ->where('status', 'active')
            ->update([
                'status' => 'inactive',
                'assigned_to' => Carbon::now()
            ]);

        if ($request->assigned_from) {
            if ($request->assigned_to) {
                CardAssignment::create([
                    'attendant_id' => $request->attendant_id,
                    'card_id' => $request->card_id,
                    'assigned_from' => $request->assigned_from,
                    'assigned_to' => $request->assigned_to,
                    'status' => 'active'
                ]);
            }
            else{
                CardAssignment::create([
                    'attendant_id' => $request->attendant_id,
                    'card_id' => $request->card_id,
                    'assigned_from' => $request->assigned_from,
                    'status' => 'active'
                ]);
            }

        } 
        else {
            CardAssignment::create([
                'attendant_id' => $request->attendant_id,
                'card_id' => $request->card_id,
                'assigned_from' => Carbon::now(),
                'status' => 'active'
            ]);
        }
        // Assign to new attendant

        return redirect()->route('card-assignment.index')->with('message', 'Card assigned successfully');
    }

    public function edit($id)
    {
        $assignment = CardAssignment::findOrFail($id);
        $attendants = \App\Models\Attendant::all();
        $cards = \App\Models\Card::all();
        return view('card_assignment.edit', compact('assignment', 'attendants', 'cards'));
    }

    public function update(Request $request, $id)
    {
        $assignment = CardAssignment::findOrFail($id);
        $request->validate([
            'attendant_id' => 'required|exists:attendants,id',
            'card_id' => 'required|exists:cards,id',
        ]);
        if ($request->assigned_from) {
            if ($request->assigned_to) {
                CardAssignment::update([
                    'attendant_id' => $request->attendant_id,
                    'card_id' => $request->card_id,
                    'assigned_from' => $request->assigned_from,
                    'assigned_to' => $request->assigned_to,
                    'status' => 'active'
                ]);
            }
            else{
                CardAssignment::update([
                    'attendant_id' => $request->attendant_id,
                    'card_id' => $request->card_id,
                    'assigned_from' => $request->assigned_from,
                    'status' => 'active'
                ]);
            }

        } 
        else {
            CardAssignment::update([
                'attendant_id' => $request->attendant_id,
                'card_id' => $request->card_id,
                'assigned_from' => Carbon::now(),
                'status' => 'active'
            ]);
        }
        return redirect()->route('card-assignment.index')->with('message', 'Assignment updated successfully');
    }

    public function destroy($id)
    {
        $assignment = CardAssignment::findOrFail($id);
        $assignment->delete();
        return redirect()->route('card-assignment.index')->with('message', 'Assignment deleted successfully');
    }
}
