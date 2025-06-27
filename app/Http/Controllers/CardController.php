<?php
namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index() {
        $cards = Card::all();
        return view('card.index', compact('cards'));
    }

    public function create() {
        return view('card.create');
    }

    public function store(Request $request) {
        $request->validate([
            'number' => 'required|unique:cards,number',
        ]);
        Card::create(['number' => $request->number]);
        return redirect()->route('card.index')->with('message', 'Card created successfully');
    }

    public function edit($id) {
        $card = Card::findOrFail($id);
        return view('card.edit', compact('card'));
    }

    public function update(Request $request, $id) {
        $card = Card::findOrFail($id);
        $request->validate([
            'number' => 'required|unique:cards,number,' . $id,
        ]);
        $card->number = $request->number;
        $card->save();
        return redirect()->route('card.index')->with('message', 'Card updated successfully');
    }

    public function destroy($id) {
        $card = Card::findOrFail($id);
        $card->delete();
        return redirect()->route('card.index')->with('message', 'Card deleted successfully');
    }
}
