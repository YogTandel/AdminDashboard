<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    // SettingController.php
    public function setting()
    {
        $selectedAgent = null;

        if (session()->has('selected_agent')) {
            $selectedAgent = session('selected_agent');
        } elseif (isset($_COOKIE['selectedAgent'])) {
            $selectedAgent = json_decode($_COOKIE['selectedAgent'], true);
        }

        return view('pages.setting', [
            'selectedAgent' => $selectedAgent,
            'settings'      => Setting::where('agent_id', $selectedAgent['id'] ?? null)->first(),
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
        Setting::update(
            ['agent_id' => $validated['agent_id']],
            [
                'agentComission'       => $validated['agent_commission'],
                'distributorComission' => $validated['distributor_commission'],
                // Add other fields as needed
            ]
        );

        return back()->with('success', 'Commissions updated successfully');
    }

    public function updateNegativeAgent(Request $request)
    {
        $request->validate([
            'agent_id' => 'nullable|exists:users,_id',
        ]);

        $agentId = $request->input('agent_id');

        // Convert empty string to null
        if ($agentId === 'null' || $agentId === '' || $agentId === null) {
            $agentId = null;
        }

        // Update all settings (as per your current logic)
        DB::table('settings')->update([
            'is_nagative_agent' => $agentId,
            'updated_at'        => now(), // Include this to track changes
        ]);

        return response()->json([
            'status'   => 'success',
            'agent_id' => $agentId,
        ]);
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
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        $transferTo = null;
        $userType = '';
        $balanceField = 'endpoint'; // Default for distributor

        if ($user->role === 'player') {
            $transferTo = User::where('id', $user->agent_id)->first();
            $userType = 'Player';
            $balanceField = 'balance';
        } elseif ($user->role === 'agent') {
            $transferTo = User::where('id', $user->distributor_id)->first();
            $userType = 'Agent';
            $balanceField = 'endpoint';
        } elseif ($user->role === 'distributor') {
            $transferTo = Admin::first();
            $userType = 'Distributor';
            $balanceField = 'endpoint';
        }

        return view('pages.transfer.form', [
            'user' => $user,
            'transferTo' => $transferTo,
            'userType' => $userType,
            'balanceField' => $balanceField,
            'currentBalance' => $user->{$balanceField},
        ]);
    }

public function processTransfer(Request $request)
{
    DB::connection('mongodb')->beginTransaction();
    try {
        $validated = $request->validate([
            'transfer_by' => 'required|exists:users,_id',
            'transfer_to' => 'required',
            'amount' => 'required|numeric|min:100',
            'type' => 'required|in:subtract,add'
        ]);

        $transferBy = \App\Models\User::findOrFail($validated['transfer_by']);
        $transferTo = \App\Models\Admin::where('_id', $validated['transfer_to'])->first();

        if (!$transferTo) {
            throw new \Exception('Recipient admin not found');
        }

        $balanceField = $transferBy->role === 'player' ? 'balance' : 'endpoint';
        
        // Properly handle Decimal128 values
        $amount = $validated['amount'];
        $transferByBalance = $this->convertDecimal128($transferBy->$balanceField);
        $transferToBalance = $this->convertDecimal128($transferTo->endpoint);

        if ($validated['type'] === 'subtract') {
            if ($transferByBalance < $amount) {
                throw new \Exception('Insufficient balance');
            }
            $transferBy->$balanceField = $transferByBalance - $amount;
            $transferTo->endpoint = $transferToBalance + $amount;
        } else {
            if ($transferToBalance < $amount) {
                throw new \Exception('Recipient has insufficient balance');
            }
            $transferBy->$balanceField = $transferByBalance + $amount;
            $transferTo->endpoint = $transferToBalance - $amount;
        }

        if (!$transferBy->save() || !$transferTo->save()) {
            throw new \Exception('Failed to save balances');
        }

        DB::connection('mongodb')->table('transfers')->insert([
            'transfer_by' => $transferBy->_id,
            'transfer_to' => $transferTo->_id,
            'amount' => $amount,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::connection('mongodb')->commit();

        return response()->json([
            'success' => true, 
            'new_balance' => $transferBy->$balanceField
        ]);

    } catch (\Exception $e) {
        DB::connection('mongodb')->rollBack();
        \Log::error('Transfer Error: '.$e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Transfer failed: '.$e->getMessage()
        ], 500);
    }
}

protected function convertDecimal128($value)
{
    if ($value instanceof \MongoDB\BSON\Decimal128) {
        return (float)(string)$value;
    }
    return (float)$value;
}

    public function showTransferReport()
    {
        $transfers = DB::table('transfers')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($transfers->isEmpty()) {
            return view('pages.transfer.report', compact('transfers'));
        }

        // Get all unique user IDs
        $userIds = $transfers->pluck('transfer_by')
            ->merge($transfers->pluck('transfer_to'))
            ->unique()
            ->filter()
            ->map(fn($id) => (string) $id); // cast to string

        // MongoDB query
        $users = User::whereIn('_id', $userIds->all())->get()
            ->keyBy(fn($u) => (string) $u->_id);

        foreach ($transfers as $transfer) {
            $transfer_by = (string) $transfer->transfer_by;
            $transfer_to = (string) ($transfer->transfer_to ?? '');

            $transfer->agent_name       = $users[$transfer_by]->player ?? 'N/A';
            $transfer->distributor_name = $users[$transfer_to]->player ?? 'N/A';
        }

        return view('pages.transfer.report', compact('transfers'));
    }

}
