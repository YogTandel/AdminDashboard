<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PagesController extends Controller
{
    public function agentList()
    {
        $perPage = request()->get('per_page', 5);
        $query   = User::query();

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from      = request()->input('from_date');
        $to        = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Ymd');
                $to   = $today->format('Ymd');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Ymd');
                $to   = $today->format('Ymd');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Ymd');
                $to   = $today->format('Ymd');
            }
        }

        if ($from) {
            $query->where('DateOfCreation', '>=', $from);
        }

        if ($to) {
            $query->where('DateOfCreation', '<=', $to);
        }

        $agents = $query->where('role', 'agent')
            ->paginate($perPage)
            ->appends(request()->query());

        return view('pages.agent.list', compact('agents', 'perPage'));
    }

    public function distributor()
    {
        $perPage = request()->get('per_page', 5);
        $query   = User::query();

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from      = request()->input('from_date');
        $to        = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Ymd');
                $to   = $today->format('Ymd');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Ymd');
                $to   = $today->format('Ymd');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Ymd');
                $to   = $today->format('Ymd');
            }
        }

        if ($from) {
            $query->where('DateOfCreation', '>=', $from);
        }

        if ($to) {
            $query->where('DateOfCreation', '<=', $to);
        }

        $distributors = $query->where('role', 'distributor')
            ->paginate($perPage)
            ->appends(request()->query());

        return view('pages.distributor.list', compact('distributors', 'perPage'));
    }

    public function player()
    {
        $perPage = request()->get('per_page', 5);
        $query   = User::query();

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from      = request()->input('from_date');
        $to        = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Ymd');
                $to   = $today->format('Ymd');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Ymd');
                $to   = $today->format('Ymd');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Ymd');
                $to   = $today->format('Ymd');
            }
        }

        if ($from) {
            $query->where('DateOfCreation', '>=', $from);
        }

        if ($to) {
            $query->where('DateOfCreation', '<=', $to);
        }

        $players = $query->where('role', 'player')
            ->paginate($perPage)
            ->appends(request()->query());

        // Debug logging (kept from your original code)
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

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('from', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from      = request()->input('from_date');
        $to        = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Y-m-d');
                $to   = $today->format('Y-m-d');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Y-m-d');
                $to   = $today->format('Y-m-d');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Y-m-d');
                $to   = $today->format('Y-m-d');
            }
        }

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        $transactions = $query->paginate($perPage)->appends(request()->query());

        return view('pages.transactionreport', compact('transactions', 'perPage'));
    }

    public function playerHistory(Request $request, $id)
    {
        $from      = $request->input('from_date');
        $to        = $request->input('to_date');
        $dateRange = $request->input('date_range');

        $player = User::where('_id', $id)
            ->where('role', 'player')
            ->firstOrFail();

        if ($player->gameHistory && is_array($player->gameHistory)) {
            $filteredHistory = collect($player->gameHistory);

            if ($dateRange) {
                $today = Carbon::today();
                if ($dateRange === '2_days_ago') {
                    $from = $today->copy()->subDays(2)->format('Y-m-d');
                    $to   = $today->format('Y-m-d');
                } elseif ($dateRange === 'this_week') {
                    $from = $today->copy()->startOfWeek()->format('Y-m-d');
                    $to   = $today->format('Y-m-d');
                } elseif ($dateRange === 'this_month') {
                    $from = $today->copy()->startOfMonth()->format('Y-m-d');
                    $to   = $today->format('Y-m-d');
                }
            }

            if ($from) {
                $filteredHistory = $filteredHistory->filter(function ($entry) use ($from) {
                    $entryDate = Carbon::createFromFormat('YmdHis', $entry['stime'])->format('Y-m-d');
                    return $entryDate >= $from;
                });
            }

            if ($to) {
                $filteredHistory = $filteredHistory->filter(function ($entry) use ($to) {
                    $entryDate = Carbon::createFromFormat('YmdHis', $entry['stime'])->format('Y-m-d');
                    return $entryDate <= $to;
                });
            }

            $player->gameHistory = $filteredHistory->values()->all();
        }

        return view('pages.player.history', compact('player'));
    }

    public function selectAgent(Request $request)
    {
        $agent = User::where('id', $request->agent_id)
            ->where('role', 'agent')
            ->firstOrFail();

        $selectedAgent = [
            'id'          => $agent->id,
            'name'        => $agent->player,
            'balance'     => $agent->balance,
            'distributor' => $agent->distributor,
            'endpoint'    => $agent->endpoint,
        ];

        // Store in session
        session(['selected_agent' => $selectedAgent]);

        // Redirect to settings page
        return redirect()->route('setting');
    }

    public function setting()
    {
        $selectedAgent = null;

        // Check session first
        if (session()->has('selected_agent')) {
            $selectedAgent = session('selected_agent');
        }
        // Fallback to cookie
        elseif (isset($_COOKIE['selectedAgent'])) {
            $selectedAgent = json_decode($_COOKIE['selectedAgent'], true);
            // Verify the agent exists
            $agentExists = User::where('id', $selectedAgent['id'] ?? null)
                ->where('role', 'agent')
                ->exists();
            if (! $agentExists) {
                $selectedAgent = null;
            }
        }

        // Get settings for this agent
        $settings = Setting::where('agent_id', $selectedAgent['id'] ?? null)->first();

        // If no settings exist, create default ones
        if (! $settings && $selectedAgent) {
            $settings = Setting::create([
                'agent_id'               => $selectedAgent['id'],
                'agent_commission'       => 5.0, // default values
                'distributor_commission' => 0.1,
            ]);
        }

        return view('pages.setting', [
            'selectedAgent' => $selectedAgent,
            'settings'      => $settings,
        ]);
    }

    public function updateCommissions(Request $request)
    {
        $validated = $request->validate([
            'agent_commission'       => 'required|numeric|min:0|max:100',
            'distributor_commission' => 'required|numeric|min:0|max:100',
            'agent_id'               => 'required|exists:users,_id',
        ]);

        // Update or create settings
        Setting::updateOrCreate(
            ['agent_id' => $validated['agent_id']],
            [
                'agentComission'       => $validated['agent_commission'],
                'distributorComission' => $validated['distributor_commission'],
                // Add other fields as needed
            ]
        );

        return back()->with('success', 'Commissions updated successfully');
    }

    public function deselect(Request $request)
    {
        $request->session()->forget('selected_agent');
        return back();
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
                $time = Carbon::createFromFormat('YmdHis', $entry['stime'])->format('Y-m-d H:i:s');

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

    public function transferForm()
    {
        return view('pages.transfer.form');
    }
}
