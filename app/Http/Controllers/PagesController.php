<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function agentList()
    {
        $agents = User::where('role', 'agent')->get();
        return view('pages.agentlist', compact('agents'));
    }

    public function addAgent(Request $request)
    {
        $validated = $request->validate([
            'player'            => 'required|string',
            'role'              => 'required|string|in:agent',
            'balance'           => 'required|integer',
            'distributor'       => 'required|string',
            'agent'             => 'required|string',
            'status'            => 'required|string|in:Active,Inactive',
            'password'          => 'required|string',
            'original_password' => 'required|string|same:password',
        ]);

        // Add current timestamp in YmdHis format for DateOfCreation
        $validated['DateOfCreation'] = now()->format('YmdHis');

        User::create($validated);

        return redirect()->route('agentlist')->with('success', 'Agent added successfully');
    }

    public function distributor()
    {
        $distributors = User::where('role', 'distributor')->get();
        return view('pages.distributor', compact('distributors'));
    }

    public function player()
    {
        $players = User::where('role', 'player')->get();
        return view('pages.player', compact('players'));
    }

    public function transactionreport()
    {
        return view('pages.transactionreport');
    }

    public function setting()
    {
        return view('pages.setting');
    }

    public function liveGame()
    {
        return view('pages.livegame');
    }
}
