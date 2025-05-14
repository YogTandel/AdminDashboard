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

    public function createAgent()
    {
        $agents = User::where('role', 'agent')->get();
        return view('pages.createagent', compact('agents'));
    }

    public function addAgent(Request $request)
    {
        $request->validate([
            'player'      => 'required|string|unique:users,player',
            'password'    => 'required|string|min:6',
            'role'        => 'required|string|in:agent',
            'balance'     => 'required|numeric|min:0',
            'distributor' => 'required|string',
            'agent'       => 'required|string',
            'status'      => 'required|string|in:Active,Inactive',
        ]);

        $agent = User::create([
            'player'            => $request->player,
            'password'          => bcrypt($request->password),
            'original_password' => $request->password,
            'role'              => $request->role,
            'balance'           => $request->balance,
            'distributor'       => $request->distributor,
            'agent'             => $request->agent,
            'status'            => $request->status,
        ]);

        return redirect()->route('agentlist.show')->with('success', 'Agent added successfully');
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
