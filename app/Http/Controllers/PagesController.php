<?php
namespace App\Http\Controllers;

use App\Models\User;

class PagesController extends Controller
{
    public function agentList()
    {
        $query = User::query();
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }
        $agents = $query->where('role', 'agent')->paginate(5);
        // $agents = User::where('role', 'agent')->paginate(5);
        return view('pages.agent.list', compact('agents'));
    }

    public function distributor()
    {
        $distributors = User::where('role', 'distributor')->paginate(5);
        return view('pages.distributor.list', compact('distributors'));
    }

    public function player()
    {
        $players = User::where('role', 'player')->paginate(5);
        return view('pages.player.list', compact('players'));
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
