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
            'player'      => 'required|string|unique:users,player',
            'password'    => 'required|string|min:6',
            'role'        => 'required|string|in:agent',
            'balance'     => 'required|numeric|min:0',
            'distributor' => 'required|string',
            'agent'       => 'required|string',
            'status'      => 'required|string|in:Active,Inactive',
        ]);

        try {
            // Store original password before hashing
            $validated['original_password'] = $validated['password'];
            $validated['password']          = bcrypt($validated['password']); // Hash password

            // Add current timestamp in YmdHis format for DateOfCreation
            $validated['DateOfCreation'] = now()->format('YmdHis');

            User::create($validated);

            return redirect()->route('agentlist.show')->with('success', 'Agent added successfully');
        } catch (\Exception $e) {
            return redirect()->route('agentlist.show')->with('error', 'Failed to add agent. ' . $e->getMessage());
        }
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
