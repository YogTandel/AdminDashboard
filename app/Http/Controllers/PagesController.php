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

    public function playerHistory($id)
    {
        $player = User::where('_id', $id)
            ->where('role', 'player')
            ->firstOrFail();
        return view('pages.player.history', compact('player'));
    }

    public function setting()
    {
        return view('pages.setting');
    }

    public function liveGame()
    {
        return view('pages.livegame');
    }

    public function exportGameHistory($playerId)
    {
        // Find player with role validation
        $player = User::where('_id', $playerId)
            ->where('role', 'player')
            ->firstOrFail();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="game_history_' . $player->player . '_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($player) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Time', 'Bet Amount', 'Win Amount', 'Net Result', 'Game Result', 'Bet Values']);

            foreach ($player->gameHistory as $entry) {
                $net  = $entry['winpoint'] - $entry['playPoint'];
                $time = \Carbon\Carbon::createFromFormat('YmdHis', $entry['stime'])->format('Y-m-d H:i:s');

                fputcsv($file, [
                    $time,
                    $entry['playPoint'],
                    $entry['winpoint'],
                    $net,
                    $entry['result'],
                    implode('|', $entry['betValues']),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
