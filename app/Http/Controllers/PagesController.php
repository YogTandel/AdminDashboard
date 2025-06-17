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
            $transferTo = User::where('role', 'admin')
                            ->where('status', 'Active')
                            ->first();
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
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'transfer_by' => 'required|exists:users,id',
                'transfer_to' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:100', // Minimum ₹100
                'type' => 'required|in:subtract,add',
            ]);

            $transfer_by = User::findOrFail($validated['transfer_by']);
            $transfer_to = User::findOrFail($validated['transfer_to']);
            $transfer_role = $transfer_by->role;

            // Distributor specific checks
            if ($transfer_by->role === 'distributor') {
                if ($transfer_to->role !== 'admin') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Distributors can only transfer to admin',
                    ], 422);
                }

                if ($transfer_to->status !== 'Active') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recipient admin is not active',
                    ], 422);
                }
            }

            // Determine allowed recipients
            $allowedRecipients = [];
            switch ($transfer_by->role) {
                case 'player':
                    $allowedRecipients = ['player', 'agent', 'distributor', 'admin'];
                    break;
                case 'agent':
                    $allowedRecipients = ['agent', 'distributor', 'admin'];
                    break;
                case 'distributor':
                    $allowedRecipients = ['admin']; // Only admin
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Your role cannot perform transfers',
                    ], 403);
            }

            if (!in_array($transfer_to->role, $allowedRecipients)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only transfer to: ' . implode(', ', $allowedRecipients),
                ], 422);
            }

            $balanceField = $transfer_by->role === 'player' ? 'balance' : 'endpoint';

            // Perform transfer calculations
            if ($validated['type'] === 'subtract') {
                if ($transfer_by->$balanceField < $validated['amount']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient balance.',
                    ], 422);
                }

                $transfer_by->$balanceField -= $validated['amount'];
                $transfer_to->endpoint += $validated['amount'];
            } else {
                $roleHierarchy = ['admin' => 4, 'distributor' => 3, 'agent' => 2, 'player' => 1];
                if ($roleHierarchy[$transfer_by->role] <= $roleHierarchy[$transfer_to->role]) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You can only add funds to accounts with lower privileges.',
                    ], 422);
                }

                if ($transfer_to->endpoint < $validated['amount']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recipient has insufficient endpoint balance.',
                    ], 422);
                }

                $transfer_by->$balanceField += $validated['amount'];
                $transfer_to->endpoint -= $validated['amount'];
            }

            // Save both users
            if (!$transfer_by->save() || !$transfer_to->save()) {
                throw new \Exception('Failed to save user balances');
            }

            // Create transfer record
            DB::connection('mongodb')->table('transfers')->insert([
                'transfer_by' => $transfer_by->id,
                'transfer_to' => $transfer_to->id,
                'type' => implode(',', $allowedRecipients),
                'amount' => $validated['amount'],
                'remaining_balance' => $transfer_by->$balanceField,
                'transfer_role' => $transfer_role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transfer successful.',
                'new_balance' => $transfer_by->$balanceField,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transfer failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Transfer failed. Please try again.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null,
            ], 500);
        }
    }

 public function login(Request $request)
    {
        $credentials = $request->validate([
            'player'   => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,distributor,agent,player',
        ]);

        $guard = $credentials['role'] === 'admin' ? 'admin' : 'web';

        $loginData = [
            'player'   => $credentials['player'],
            'password' => $credentials['password'],
        ];

        if ($guard !== 'admin') {
            $loginData['status'] = 'Active';
        }

        if (Auth::guard($guard)->attempt($loginData)) {
            $request->session()->regenerate();

            $user = Auth::guard($guard)->user();

            if ($guard !== 'admin' && $user->role !== $credentials['role']) {
                Auth::guard($guard)->logout();
                return back()->withErrors([
                    'credentials' => 'Invalid role for this user.',
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Invalid credentials',
        ]);
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
