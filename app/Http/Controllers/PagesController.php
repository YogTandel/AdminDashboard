<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Bet;
use App\Models\Release;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\ObjectId;

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

        // Fetch agents
        $agents = $query->where('role', 'agent')
            ->paginate($perPage)
            ->appends(request()->query());

        // 🔥 Fetch all distributors for dropdown
        $distributors = User::where('role', 'distributor')->get();

        // Pass to view
        return view('pages.agent.list', compact('agents', 'perPage', 'distributors'));
    }

    public function distributor()
    {
        $perPage = request()->get('per_page', 5);
        $query   = User::query();

        // Search filter
        if (request()->has('search')) {
            $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from      = request()->input('from_date');
        $to        = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();

            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('YmdHis');
                $to   = $today->copy()->endOfDay()->format('YmdHis');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('YmdHis');
                $to   = $today->copy()->endOfDay()->format('YmdHis');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('YmdHis');
                $to   = $today->copy()->endOfDay()->format('YmdHis');
            }
        }

        // Cast from/to to float (since stored as double)
        if ($from) {
            $query->where('DateOfCreation', '>=', (float) $from);
        }

        if ($to) {
            $query->where('DateOfCreation', '<=', (float) $to);
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
            $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from      = request()->input('from_date');
        $to        = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = \Carbon\Carbon::today();

            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('YmdHis');
                $to   = $today->copy()->endOfDay()->format('YmdHis');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('YmdHis');
                $to   = $today->copy()->endOfDay()->format('YmdHis');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('YmdHis');
                $to   = $today->copy()->endOfDay()->format('YmdHis');
            }
        }

        if ($from) {
            $query->where('DateOfCreation', '>=', (float) $from);
        }

        if ($to) {
            $query->where('DateOfCreation', '<=', (float) $to);
        }

        // Players list with relation
        $players = $query->where('role', 'player')
            ->with(['agentUser'])
            ->paginate($perPage)
            ->appends(request()->query());

        // Dropdown lists
        $agents       = User::where('role', 'agent')->get(['_id', 'player']);
        $distributors = User::where('role', 'distributor')->get(['_id', 'player']);

        return view('pages.player.list', compact('players', 'perPage', 'agents', 'distributors'));
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
        $from        = $request->input('from_date');
        $to          = $request->input('to_date');
        $dateRange   = $request->input('date_range');
        $perPage     = $request->input('per_page', 10); // Get per_page from request or default to 10
        $currentPage = $request->get('page', 1);

        $player = User::where('_id', $id)
            ->where('role', 'player')
            ->firstOrFail();

        if ($player->gameHistory && is_array($player->gameHistory)) {
            $filteredHistory = collect($player->gameHistory);

            // Handle Quick Date Range
            $today = \Carbon\Carbon::today();
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

            // Filter with dates
            if ($from) {
                $filteredHistory = $filteredHistory->filter(function ($entry) use ($from) {
                    if (isset($entry['stime'])) {
                        try {
                            $entryDate = \Carbon\Carbon::createFromFormat('Y/m/d H:i:s', $entry['stime'])->format('Y-m-d');
                            return $entryDate >= $from;
                        } catch (\Exception $e) {
                            try {
                                $entryDate = \Carbon\Carbon::parse($entry['stime'])->format('Y-m-d');
                                return $entryDate >= $from;
                            } catch (\Exception $e) {
                                return false;
                            }
                        }
                    }
                    return false;
                });
            }

            if ($to) {
                $filteredHistory = $filteredHistory->filter(function ($entry) use ($to) {
                    if (isset($entry['stime'])) {
                        try {
                            $entryDate = \Carbon\Carbon::createFromFormat('Y/m/d H:i:s', $entry['stime'])->format('Y-m-d');
                            return $entryDate <= $to;
                        } catch (\Exception $e) {
                            try {
                                $entryDate = \Carbon\Carbon::parse($entry['stime'])->format('Y-m-d');
                                return $entryDate <= $to;
                            } catch (\Exception $e) {
                                return false;
                            }
                        }
                    }
                    return false;
                });
            }

            // Sort by date descending (newest first)
            $filteredHistory = $filteredHistory->sortByDesc(function ($entry) {
                if (isset($entry['stime'])) {
                    try {
                        return \Carbon\Carbon::createFromFormat('Y/m/d H:i:s', $entry['stime'])->timestamp;
                    } catch (\Exception $e) {
                        try {
                            return \Carbon\Carbon::parse($entry['stime'])->timestamp;
                        } catch (\Exception $e) {
                            return 0;
                        }
                    }
                }
                return 0;
            });

            // Create paginator
            $paginatedHistory = new \Illuminate\Pagination\LengthAwarePaginator(
                $filteredHistory->forPage($currentPage, $perPage),
                $filteredHistory->count(),
                $perPage,
                $currentPage,
                [
                    'path'  => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                    'query' => $request->query(),
                ]
            );

            $player->gameHistory = $paginatedHistory->items();
        } else {
            $paginatedHistory = null;
        }

        return view('pages.player.history', compact('player', 'paginatedHistory'));
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

    public function settings()
    {

        $settings = Setting::first();

        $selectedAgent = null;

        if (session()->has('selected_agent')) {
            $selectedAgent = session('selected_agent');
        } elseif (isset($_COOKIE['selectedAgent'])) {
            $selectedAgent = json_decode($_COOKIE['selectedAgent'], true);
        }

        return view('pages.setting', [
            'settings'      => $settings,
            'selectedAgent' => $selectedAgent,
            'standing'      => $settings->standing,
        ]);
    }

    public function updateCommissions(Request $request)
    {
        $validated = $request->validate([
            'agent_commission'       => 'required|numeric|min:0|max:100',
            'distributor_commission' => 'required|numeric|min:0|max:100',
        ]);

        DB::table('settings')->update([
            'agentComission'       => $validated['agent_commission'],
            'distributorComission' => $validated['distributor_commission'],
            'updated_at'           => now(),
        ]);

        return back()->with('success', 'Commissions updated successfully.');
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

    public function toggleSetToMinimum(Request $request)
    {
        $setting = DB::table('settings')->first();

        if (! $setting) {
            return response()->json(['error' => 'Settings not found'], 404);
        }

        $newValue = ! $setting->setTominimum;

        DB::table('settings')->update([
            'setTominimum' => $newValue,
            'updated_at'   => now(),
        ]);

        return response()->json([
            'status'       => 'success',
            'setTominimum' => $newValue,
        ]);
    }

    public function standingToEarning(Request $request)
    {
        // છેલ્લો inserted settings record લો
        $setting = DB::table('settings')->latest('id')->first();

        if (! $setting) {
            return redirect()->back()->with('error', 'No settings record found.');
        }

        // નવા earning ની ગણતરી
        $newEarning = $setting->earning + $setting->standing;

        // Update earning અને standing બંને
        DB::table('settings')
            ->where('id', $setting->id)
            ->update([
                'earning'    => $newEarning,
                'standing'   => 0, // standing હવે 0 થાય
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Earning updated and standing set to 0.');
    }

    public function earningToZero(Request $request)
    {
        $setting = DB::table('settings')->latest('id')->first();

        if (! $setting) {
            return redirect()->back()->with('error', 'No settings record found.');
        }

        DB::table('settings')
            ->where('id', $setting->id)
            ->update([
                'earning'    => 0,
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Earning set to 0 successfully.');
    }

    public function updateProfit(Request $request)
    {
        $request->validate([
            'earningPercentage' => 'required|numeric|min:0|max:100',
        ]);

        $setting = DB::table('settings')->latest('id')->first();

        if (! $setting) {
            return redirect()->back()->with('error', 'Settings record not found.');
        }

        DB::table('settings')
            ->where('id', $setting->id)
            ->update([
                'earningPercentage' => $request->earningPercentage,
                'updated_at'        => now(),
            ]);

        return redirect()->back()->with('success', 'Earning percentage updated successfully.');
    }

    public function addPointsToAdmin(Request $request)
    {
        $request->validate([
            'add_points' => 'required|numeric|min:1',
        ]);

        $admin = DB::table('admins')->first();

        if (! $admin) {
            return back()->with('error', 'No Admin record .');
        }

        DB::table('admins')->where('id', $admin->id)->update([
            'endpoint'   => $admin->endpoint + $request->add_points,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Points added suceessfully.');
    }

    public function removePointsFromAdmin(Request $request)
    {
        $request->validate([
            'remove_points' => 'required|numeric|min:1',
        ]);

        $admin = DB::table('admins')->first();

        if (! $admin) {
            return back()->with('error', 'No Admin record .');
        }

        if ($admin->endpoint < $request->remove_points) {
            return back()->with('error', ' no Enough points .');
        }

        // Update (subtract) endpoint
        DB::table('admins')->where('id', $admin->id)->update([
            'endpoint'   => $admin->endpoint - $request->remove_points,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Points were successfully deducted from Admin.');
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

    public function liveGamevalue()
    {
        $setting = Setting::first();

        return response()->json([
            'standing' => $setting->standing ?? 0,
            'earning'  => $setting->earning ?? 0,
            'result'   => $setting->result ?? '--',
        ]);
    }

    public function getBetTotals()
    {
        $bets   = DB::table('bets')->get();
        $totals = array_fill(0, 10, 0);

        foreach ($bets as $bet) {
            foreach ($bet->bet ?? [] as $key => $value) {
                $index = (int) $key;
                $totals[$index] += (int) $value;
            }
        }

        return response()->json([
            'totals'     => $totals,
            'grandTotal' => array_sum($totals),
        ]);
    }

    public function getLivePlayers()
    {
        $players = User::where('role', 'player')
            ->where('login_status', true)
            ->get();

        $result = [];

        foreach ($players as $player) {
            $history = $player->gameHistory;
            if (! empty($history)) {
                $lastGame  = end($history);
                $betValues = $lastGame['betValues'] ?? [];

                $result[] = [
                    'name'      => $player->player,
                    'betValues' => $betValues,
                    'total'     => array_sum($betValues),
                ];
            }
        }

        return response()->json(['players' => $result]);
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

        if (! $user) {
            abort(403, 'Unauthorized access');
        }

        $transferTo   = null;
        $userType     = '';
        $balanceField = 'endpoint'; // Default

        if ($user->role === 'player') {
            $transferTo   = User::where('id', $user->agent_id)->first();
            $userType     = 'Player';
            $balanceField = 'balance';
        } elseif ($user->role === 'agent') {
            $transferTo   = User::where('id', $user->distributor_id)->first();
            $userType     = 'Agent';
            $balanceField = 'endpoint';
        }

        return view('pages.transfer.form', [
            'user'           => $user,
            'transferTo'     => $transferTo,
            'userType'       => $userType,
            'balanceField'   => $balanceField,
            'currentBalance' => $user->{$balanceField},
        ]);
    }

    public function processTransfer(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'transfer_by'        => 'required|exists:users,id',
                'transfer_to'        => 'required', // We'll handle validation manually
                'amount'             => 'required|numeric|min:0.01',
                'type'               => 'required|in:subtract,add',
                'is_admin_recipient' => 'sometimes|boolean', // New field to identify admin recipients
            ]);

            $transfer_by   = User::findOrFail($validated['transfer_by']);
            $transfer_role = $transfer_by->role;

            // Determine allowed recipients and their models
            $allowedRecipients = [];
            $recipientModel    = null;
            $isRecipientAdmin  = $validated['is_admin_recipient'] ?? false;

            switch ($transfer_by->role) {
                case 'player':
                    $allowedRecipients = ['player', 'agent', 'distributor', 'admin'];
                    break;
                case 'agent':
                    $allowedRecipients = ['agent', 'distributor', 'admin'];
                    break;
                case 'distributor':
                    $allowedRecipients = ['distributor', 'admin'];
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Your role cannot perform transfers',
                    ], 403);
            }

            // Find the recipient - could be User or Admin
            if ($isRecipientAdmin) {
                $transfer_to   = Admin::findOrFail($validated['transfer_to']);
                $recipientRole = 'admin';
            } else {
                $transfer_to   = User::findOrFail($validated['transfer_to']);
                $recipientRole = $transfer_to->role;
            }

            if (! in_array($recipientRole, $allowedRecipients)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only transfer to: ' . implode(', ', $allowedRecipients),
                ], 422);
            }

            $balanceField = $transfer_by->role === 'player' ? 'balance' : 'endpoint';

            // Perform the transfer calculations
            if ($validated['type'] === 'subtract') {
                if ($transfer_by->$balanceField < $validated['amount']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient balance.',
                    ], 422);
                }

                $transfer_by->$balanceField -= $validated['amount'];
                $transfer_to->endpoint += $validated['amount']; // Always use endpoint for admin
            } else {
                // For add operations, validate hierarchy
                $roleHierarchy = ['admin' => 4, 'distributor' => 3, 'agent' => 2, 'player' => 1];
                if ($roleHierarchy[$transfer_by->role] <= $roleHierarchy[$recipientRole]) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You can only add funds to accounts with lower privileges.',
                    ], 422);
                }

                $recipientBalance = $transfer_to->endpoint; // Always check endpoint for admin
                if ($recipientBalance < $validated['amount']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recipient has insufficient endpoint balance.',
                    ], 422);
                }

                $transfer_by->$balanceField += $validated['amount'];
                $transfer_to->endpoint -= $validated['amount']; // Always use endpoint for admin
            }

            // Save both accounts
            if (! $transfer_by->save() || ! $transfer_to->save()) {
                throw new \Exception('Failed to save balances');
            }

            // Create transfer record with comma-separated allowed roles
            DB::connection('mongodb')->table('transfers')->insert([
                'transfer_by'       => $transfer_by->id,
                'transfer_to'       => $transfer_to->id,
                'transfer_to_model' => $isRecipientAdmin ? 'admin' : 'user',
                'type'              => implode(',', $allowedRecipients),
                'amount'            => $validated['amount'],
                'remaining_balance' => $transfer_by->$balanceField,
                'transfer_role'     => $transfer_role,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            DB::commit();

            return response()->json([
                'success'     => true,
                'message'     => 'Transfer successful.',
                'new_balance' => $transfer_by->$balanceField,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transfer failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Transfer failed. Please try again.',
                'error'   => env('APP_DEBUG') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function showTransferReport()
    {
        $user  = auth('web')->user();   // from users table
        $admin = auth('admin')->user(); // from admins table

        if (! $user && ! $admin) {
            return redirect()->route('login');
        }

        $query = DB::connection('mongodb')->table('transfers')->orderBy('created_at', 'desc');

        // If a normal user is logged in, restrict to their transfers
        if ($user) {
            $query->where('transfer_by', $user->id);
        }

        $transfers = $query->get();

        if ($transfers->isEmpty()) {
            return view('pages.transfer.report', compact('transfers'));
        }

        // Convert MongoDB IDs to strings for array keys
        $allAdmins = Admin::all()->mapWithKeys(function ($admin) {
            return [(string) $admin->_id => $admin];
        });

        $userIds = $transfers->pluck('transfer_by')
            ->merge($transfers->pluck('transfer_to'))
            ->unique()
            ->map(function ($id) {
                return (string) $id;
            });

        $users = User::whereIn('_id', $userIds)->get()->mapWithKeys(function ($user) {
            return [(string) $user->_id => $user];
        });

        foreach ($transfers as $transfer) {
            // Convert transfer IDs to strings for comparison
            $transferBy = (string) $transfer->transfer_by;
            $transferTo = (string) $transfer->transfer_to;

            // Set agent name
            $transfer->agent_name = $users[$transferBy]->player ?? 'N/A (User ID: ' . $transferBy . ')';

            // Set distributor name
            if (isset($allAdmins[$transferTo])) {
                $transfer->distributor_name = $allAdmins[$transferTo]->player ?? 'Admin';
            } else {
                $transfer->distributor_name = $users[$transferTo]->player ?? 'N/A (ID: ' . $transferTo . ')';
            }
        }

        return view('pages.transfer.report', compact('transfers'));
    }

    public function getAgents($distributorId)
    {
        try {
            $objectId = new ObjectId($distributorId);

            $agents = User::where('role', 'agent')
                ->where('distributor_id', $objectId)
                ->get(['_id', 'player']);

            $agents = $agents->map(function ($agent) {
                return [
                    '_id'    => (string) $agent->_id,
                    'player' => $agent->player,
                ];
            });

            return response()->json($agents);

        } catch (\Exception $e) {
            Log::error('Error fetching agents: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid distributor ID'], 400);
        }
    }

    public function updateCustomBet(Request $request)
    {
        $request->validate([
            'custom_bet' => 'required|integer|min:0|max:9',
        ]);

        // MongoDB ObjectId ના આધાર પર શોધો
        $setting = Setting::where('_id', new ObjectId('67d942244d741e1fb4f08710'))->first();

        if ($setting) {
            $setting->customBet = (int) $request->custom_bet;
            $setting->save();
            return back()->with('success', 'Custom Bet successfully added!');
        } else {
            return back()->with('error', 'Setting not!');
        }
    }

    public function getAdminEndpoint()
    {
        $admin = Auth::guard('admin')->user(); // assuming admin is logged in
        return response()->json(['endpoint' => $admin->endpoint ?? 'N/A']);
    }

    public function commissionReport()
    {
        $agents = User::where('role', 'agent')
            ->where('status', 'Active')
            ->get();
        //print_r($agents);
        $totalWinpointSum = 0;

        foreach ($agents as $agent) {
            $releaseDate      = $agent->release_commission_date ?? null;
            $releaseTimestamp = $releaseDate ? Carbon::parse($releaseDate)->timestamp : null;

            // $players = User::where('role', 'player')
            //     ->where('agent_id', new ObjectId($agent->_id))
            //     ->get(['gameHistory']);
            $players = User::raw(function ($collection) use ($agent) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'role'     => 'player',
                            'agent_id' => new ObjectId($agent->_id),
                        ],
                    ],
                    [
                        '$project' => [
                            'gameHistory' => [
                                '$filter' => [
                                    'input' => '$gameHistory',
                                    'as'    => 'history',
                                    'cond'  => [
                                        '$and' => [
                                            ['$eq' => ['$$history.winpoint', 0]],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]);
            });

            // print_r($players);
            // exit();
            foreach ($players as $player) {
                foreach ($player->gameHistory ?? [] as $game) {
                    //echo ''. $game->id .''. $game->name ;
                    $gameTime = strtotime(str_replace('/', '-', $game['stime']));
                    if (! $releaseTimestamp || $gameTime > $releaseTimestamp) {
                        //  echo 'hello';
                        //$totalWinpointSum += $game['winpoint'] ?? 0;
                        foreach ($game['betValues'] ?? [] as $betVal) {
                            $totalWinpointSum += $betVal;
                        }

                    }
                }
            }
        }
        // echo $totalWinpointSum;
        // exit(0);

        return view('pages.commissionReport', [
            'totalWinpointSum' => $totalWinpointSum,
        ]);

    }

    public function transferToDistributor(Request $request)
    {
        $request->validate([
            'transfer_to' => 'required|exists:users,id',
            'amount'      => 'required|numeric|min:0.01',
        ]);

        $admin       = Auth::guard('admin')->user();
        $distributor = User::where('id', $request->transfer_to)
            ->where('role', 'distributor')
            ->first();

        if (! $distributor) {
            return response()->json(['success' => false, 'message' => 'Distributor not found.']);
        }

        if ($request->amount > $admin->endpoint) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance.']);
        }

        $admin->endpoint -= $request->amount;
        $distributor->endpoint += $request->amount;

        $admin->save();
        $distributor->save();

        // ✅ MongoDB insert into `refils`
        DB::connection('mongodb')->table('refils')->insert([
            'transfer_by'       => $admin->id,
            'transfer_to'       => $distributor->id,
            'transfer_to_model' => 'user',
            'type'              => 'admin-to-distributor',
            'amount'            => $request->amount,
            'remaining_balance' => $admin->endpoint,
            'transfer_role'     => 'admin',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->back()->with('success', 'Balance transferred successfully.');
    }
    public function transferToAgent(Request $request)
    {
        $request->validate([
            'transfer_to' => 'required',
            'amount'      => 'required|numeric|min:0.01',
        ]);

        $distributor = Auth::user();
        $agent       = User::where('role', 'agent')->where('id', $request->transfer_to)->first();

        if (! $agent) {
            return back()->with('error', 'Agent not found.');
        }

        if ($request->amount > $distributor->endpoint) {
            return back()->with('error', 'Insufficient balance.');
        }

        $distributor->endpoint -= $request->amount;
        $agent->endpoint += $request->amount;

        $distributor->save();
        $agent->save();

        // ✅ MongoDB insert into `refils`
        DB::connection('mongodb')->table('refils')->insert([
            'transfer_by'       => $distributor->id,
            'transfer_to'       => $agent->id,
            'transfer_to_model' => 'user',
            'type'              => 'distributor-to-agent',
            'amount'            => $request->amount,
            'remaining_balance' => $distributor->endpoint,
            'transfer_role'     => 'distributor',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return back()->with('success', 'Balance transferred successfully.');
    }

    public function transferToPlayer(Request $request)
    {
        $request->validate([
            'transfer_to' => 'required|exists:users,id',
            'amount'      => 'required|numeric|min:0.01',
        ]);

        $agent  = Auth::user();
        $player = User::where('role', 'player')->where('id', $request->transfer_to)->first();

        if (! $player) {
            return back()->with('error', 'Player not found.');
        }

        if ($request->amount > $agent->endpoint) {
            return back()->with('error', 'Insufficient balance.');
        }

        $agent->endpoint -= $request->amount;
        $agent->save();

        $player->balance += $request->amount;
        $player->save();

        // ✅ MongoDB insert into `refils`
        DB::connection('mongodb')->table('refils')->insert([
            'transfer_by'       => $agent->id,
            'transfer_to'       => $player->id,
            'transfer_to_model' => 'user',
            'type'              => 'agent-to-player',
            'amount'            => $request->amount,
            'remaining_balance' => $agent->endpoint,
            'transfer_role'     => 'agent',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return back()->with('success', 'Balance transferred successfully.');
    }

    public function showRefilReport()
    {
        $user  = auth('web')->user();
        $admin = auth('admin')->user();

        if (! $user && ! $admin) {
            return redirect()->route('login');
        }

        $query = DB::connection('mongodb')->table('refils')->orderBy('created_at', 'desc');

        if ($user) {
            $query->where('transfer_by', $user->id);
        }

        $refils = $query->get();

        if ($refils->isEmpty()) {
            return view('pages.refil-report', compact('refils'));
        }

        // 🔍 Fetch all related users and admins
        $allAdmins = Admin::all()->keyBy('_id');
        $userIds   = $refils->pluck('transfer_by')->merge($refils->pluck('transfer_to'))->unique();
        $users     = User::whereIn('_id', $userIds)->get()->keyBy('_id');

        foreach ($refils as $refil) {

            if ($users->has($refil->transfer_by)) {
                $refil->agent_name = $users->get($refil->transfer_by)?->player ?? 'User (ID: ' . $refil->transfer_by . ')';
            } elseif ($allAdmins->has($refil->transfer_by)) {
                $refil->agent_name = $allAdmins->get($refil->transfer_by)?->player ?? 'Admin (ID: ' . $refil->transfer_by . ')';
            } else {
                $refil->agent_name = 'N/A (User ID: ' . $refil->transfer_by . ')';
            }

            if ($allAdmins->has($refil->transfer_to)) {
                $refil->distributor_name = $allAdmins->get($refil->transfer_to)?->player ?? 'Admin (ID: ' . $refil->transfer_to . ')';
            } else {
                $refil->distributor_name = $users->get($refil->transfer_to)?->player ?? 'N/A (ID: ' . $refil->transfer_to . ')';
            }
        }

        return view('pages.refil-report', compact('refils'));
    }

    public function getSettingsData()
    {
        $setting = Setting::first();

        return response()->json([

            'earning'              => $setting->earning ?? 0,
            'distributorComission' => $setting->distributorComission ?? 0,
            'agentComission'       => $setting->agentComission ?? 0,

        ]);
    }

    public function getDistributors(Request $request)
    {
        $distributors = User::where('role', 'distributor')->get();

        $data = $distributors->map(function ($distributor) {
            $releaseDate = $distributor->release_commission_date ?? null;

            return [
                'id'           => (string) $distributor->_id,
                'name'         => $distributor->player,
                'endpoint'     => $distributor->endpoint ?? 0,
                'release_date' => $releaseDate,
            ];
        });

        return response()->json($data);
    }

    public function getDistributorDetails($id)
    {
        $agents = User::where('role', 'agent')
            ->where('status', 'Active')
            ->where('distributor_id', new ObjectId($id))
            ->get();

        $totalWinpointSum_distributor = 0;
        $agent_value                  = [];

        foreach ($agents as $agent) {
            $totalWinpointSum_agent = 0;
            $releaseDate            = $agent->release_commission_date ?? null;
            $releaseTimestamp       = $releaseDate ? Carbon::parse($releaseDate)->timestamp : null;

            $players = User::raw(function ($collection) use ($agent) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'role'     => 'player',
                            'agent_id' => new ObjectId($agent->_id),
                        ],
                    ],
                    [
                        '$project' => [
                            'gameHistory' => [
                                '$filter' => [
                                    'input' => '$gameHistory',
                                    'as'    => 'history',
                                    'cond'  => [
                                        '$and' => [
                                            ['$eq' => ['$$history.winpoint', 0]],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]);
            });

            foreach ($players as $player) {
                foreach ($player->gameHistory ?? [] as $game) {
                    $gameTime = strtotime(str_replace('/', '-', $game['stime']));
                    if (! $releaseTimestamp || $gameTime > $releaseTimestamp) {
                        foreach ($game['betValues'] ?? [] as $betVal) {
                            $totalWinpointSum_agent += $betVal;
                            $totalWinpointSum_distributor += $betVal;
                        }

                    }
                }
            }

            $agent_value[] = [
                'id'        => (string) $agent->_id,
                'name'      => $agent->player,
                'date'      => optional($agent->release_commission_date)->format('Y-m-d'),
                'endpoint'  => $agent->endpoint ?? 'N/A',
                'winAmount' => $totalWinpointSum_agent, // ← per agent win point calculated

            ];
        }

        return response()->json([
            'totalWinpointSum_distributor' => $totalWinpointSum_distributor,
            'agent'                        => $agent_value,
        ]);
    }

    public function releaseCommission(Request $request)
    {
        $rules = [
            'transfer_to' => 'required|string',
            'type'        => 'required|in:distributor,agent,player',
            'total_bet'   => 'required|numeric|min:0',
            'win_amount'  => 'required|numeric|min:0',
        ];

        if ($request->type === 'distributor') {
            $rules['commission_percentage'] = 'required|numeric|min:0|max:100';
        } else {
            $rules['commission_percentage'] = 'required|numeric|min:0'; // agent: commission is currency
        }

        $request->validate($rules);

        $transferTo           = $request->transfer_to;
        $type                 = $request->type;
        $totalBet             = $request->total_bet;
        $commissionPercentage = $request->commission_percentage;
        $winAmount            = $request->win_amount;

        $commission = ($type === 'distributor')
        ? ($totalBet * $commissionPercentage) / 100
        : $commissionPercentage;

        $setting = Setting::first();
        if (! $setting) {
            return response()->json(['error' => 'System settings not found'], 400);
        }

        $systemEarningPercent = $setting->earning;
        $availableEarning     = ($winAmount * $systemEarningPercent) / 100;

        if ($availableEarning < $commission) {
            return response()->json(['error' => 'Not enough earnings in system'], 400);
        }

        $user = User::where('id', $transferTo)->where('role', $type)->first();
        if (! $user) {
            Log::error('Agent not found', [
                'transfer_to' => $transferTo,
                'type'        => $type,
            ]);
            return response()->json(['error' => ucfirst($type) . ' not found'], 404);
        }

        if ($type === 'agent') {
            $user->endpoint            = ($user->endpoint ?? 0) + $commission;
            $commissionPercentageValue = ($commission / $winAmount) * 100;
            $newSystemEarningPercent   = $systemEarningPercent - $commissionPercentageValue;

            if ($newSystemEarningPercent < 0) {
                return response()->json(['error' => 'System earning cannot go below zero'], 400);
            }

            $setting->earning = $newSystemEarningPercent;
            $setting->save();

        } elseif ($type === 'distributor') {
            $commissionPercentageValue = ($commission / $winAmount) * 100;
            $user->endpoint            = ($user->endpoint ?? 0) + $commissionPercentageValue;
            // System earning not reduced for distributor
        }

        $user->release_commission_date = now();
        $user->save();

        $remainingBalance = ($type === 'agent')
        ? ($winAmount * $setting->earning) / 100
        : ($winAmount * $systemEarningPercent) / 100;

        $name = $user->player ?? $request->name ?? 'Unknown';

        $data = Release::create([
            'transfer_to'           => $transferTo,
            'name'                  => $name,
            'type'                  => $type,
            'total_bet'             => $totalBet,
            'commission_percentage' => $commissionPercentage,
            'remaining_balance'     => $remainingBalance,
            'transfer_role'         => 'admin',
        ]);

        return response()->json([
            'success'           => true,
            'message'           => 'Commission released successfully.',
            'remaining_balance' => $remainingBalance,
            'released_at'       => now()->format('Y-m-d H:i:s'),
            'data'              => $data,
        ]);
    }

    public function relesecommissionReport()
    {
        $releases = Release::orderBy('created_at', 'desc')->get();

        return view('pages.comissiom-report', compact('releases'));
    }
    public function updateStatus(Request $request, $id)
    {
        $distributor = User::find($id);
        if ($distributor) {
            $distributor->status = $request->status;
            $distributor->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function index()
    {
        $totalAgents    = User::where('role', 'agent')->count();
        $activeAgents   = User::where('role', 'agent')->where('status', 'Active')->count();
        $deactiveAgents = User::where('role', 'agent')->where('status', 'Inactive')->count();

        $totalDistributors    = User::where('role', 'distributor')->count();
        $activeDistributors   = User::where('role', 'distributor')->where('status', 'Active')->count();
        $deactiveDistributors = User::where('role', 'distributor')->where('status', 'Inactive')->count();

        $totalPlayers    = User::where('role', 'player')->count();
        $activePlayers   = User::where('role', 'player')->where('status', 'Active')->count();
        $deactivePlayers = User::where('role', 'player')->where('status', 'Inactive')->count();

        $totalChips = User::sum('chips');
        $totalKata  = User::sum('kata');
        $totalBulk  = User::sum('bulk');

        return view('dashboard', compact(
            'totalAgents', 'activeAgents', 'deactiveAgents',
            'totalDistributors', 'activeDistributors', 'deactiveDistributors',
            'totalPlayers', 'activePlayers', 'deactivePlayers',
            'totalChips', 'totalKata', 'totalBulk'
        ));
    }

    public function toggleStatus($id)
    {
        $user = User::where('id', $id)->where('role', 'agent')->firstOrFail();

        // Toggle status
        $newStatus = $user->status === 'Active' ? 'Inactive' : 'Active';

        // Force mark dirty
        $user->status = $newStatus;
        $user->save();

        return response()->json([
            'status'  => $user->status,
            'message' => 'Agent status updated successfully.',
        ]);
    }
    public function distoggleStatus($id)
    {
        $distributor = User::where('_id', $id)->where('role', 'distributor')->firstOrFail();

        $distributor->status = $distributor->status === 'Active' ? 'Inactive' : 'Active';
        $distributor->save();

        return response()->json([
            'status'  => $distributor->status,
            'message' => 'Distributor status updated.',
        ]);
    }

}
