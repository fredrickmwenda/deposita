<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class StationController extends Controller
{
    // Provider: List all stations
    public function index()
    {
        $stations = Station::with(['client', 'stationAdmin'])->get();
        return view('stations.index', compact('stations'));
    }

    // Provider: Show create station form
    public function create()
    {
        $clients = Client::all();
        $station_admins = User::where('role', 'station_admin')->get();
        return view('stations.create', compact('clients', 'station_admins'));
    }

    // Provider: Store new station
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'station_admin_id' => 'required|exists:users,id',
        ]);
        Station::create($request->only('name', 'client_id', 'station_admin_id'));
        return redirect()->route('stations.index')->with('success', 'Station created and assigned to admin!');
    }
}
