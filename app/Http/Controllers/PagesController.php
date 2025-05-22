<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PagesController extends Controller
{
    public function agentList()
    {
        $perPage = request()->get('per_page', 5);
        $query   = User::query();
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }
        $agents = $query->where('role', 'agent')->paginate($perPage)->appends(request()->query());
        return view('pages.agent.list', compact('agents', 'perPage'));
    }

    public function distributor()
    {
        $perPage = request()->get('per_page', 5);
        $query   = User::query();
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }
        $distributors = $query->where('role', 'distributor')->paginate($perPage)->appends(request()->query());
        return view('pages.distributor.list', compact('distributors', 'perPage'));
    }

    public function player()
    {
        $perPage = request()->get('per_page', 5);
        $query   = User::query();
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }
        $players = $query->where('role', 'player')->paginate($perPage)->appends(request()->query());

        if ($players->count() > 0) {
            $firstPlayer = $players->first();
            Log::debug('gameHistory type: ' . gettype($firstPlayer->gameHistory));
            Log::debug('gameHistory content: ', is_array($firstPlayer->gameHistory) ? $firstPlayer->gameHistory : [$firstPlayer->gameHistory]);
        }

        return view('pages.player.list', compact('players', 'perPage'));
    }

    public function transactionreport()
    {
        $perPage = request()->get('per_page', 15);
        $query   = Transaction::query();
        if (request()->has('search')) {
            $query = $query->where('from', 'like', '%' . request()->search . '%');
        }
        $transactions = $query->paginate($perPage)->appends(request()->query());
        return view('pages.transactionreport', compact('transactions', 'perPage'));
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
