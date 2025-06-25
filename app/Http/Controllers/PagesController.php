<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
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
        $query = User::query();

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from = request()->input('from_date');
        $to = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Ymd');
                $to = $today->format('Ymd');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Ymd');
                $to = $today->format('Ymd');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Ymd');
                $to = $today->format('Ymd');
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
        $query = User::query();

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from = request()->input('from_date');
        $to = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Ymd');
                $to = $today->format('Ymd');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Ymd');
                $to = $today->format('Ymd');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Ymd');
                $to = $today->format('Ymd');
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
        $query = User::query();

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('player', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from = request()->input('from_date');
        $to = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Ymd');
                $to = $today->format('Ymd');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Ymd');
                $to = $today->format('Ymd');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Ymd');
                $to = $today->format('Ymd');
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
        $query = Transaction::query();

        // Search filter
        if (request()->has('search')) {
            $query = $query->where('from', 'like', '%' . request()->search . '%');
        }

        // Date range filter
        $from = request()->input('from_date');
        $to = request()->input('to_date');
        $dateRange = request()->input('date_range');

        if ($dateRange) {
            $today = Carbon::today();
            if ($dateRange === '2_days_ago') {
                $from = $today->copy()->subDays(2)->format('Y-m-d');
                $to = $today->format('Y-m-d');
            } elseif ($dateRange === 'this_week') {
                $from = $today->copy()->startOfWeek()->format('Y-m-d');
                $to = $today->format('Y-m-d');
            } elseif ($dateRange === 'this_month') {
                $from = $today->copy()->startOfMonth()->format('Y-m-d');
                $to = $today->format('Y-m-d');
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
        $from = $request->input('from_date');
        $to = $request->input('to_date');
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
                    $to = $today->format('Y-m-d');
                } elseif ($dateRange === 'this_week') {
                    $from = $today->copy()->startOfWeek()->format('Y-m-d');
                    $to = $today->format('Y-m-d');
                } elseif ($dateRange === 'this_month') {
                    $from = $today->copy()->startOfMonth()->format('Y-m-d');
                    $to = $today->format('Y-m-d');
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
            'id' => $agent->id,
            'name' => $agent->player,
            'balance' => $agent->balance,
            'distributor' => $agent->distributor,
            'endpoint' => $agent->endpoint,
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
            'settings' => Setting::where('agent_id', $selectedAgent['id'] ?? null)->first(),
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
            'settings' => $settings,
            'selectedAgent' => $selectedAgent,
            'standing' => $settings->standing
        ]);
    }

    public function updateCommissions(Request $request)
    {
        $validated = $request->validate([
            'agent_commission' => 'required|numeric|min:0|max:100',
            'distributor_commission' => 'required|numeric|min:0|max:100',
        ]);

        DB::table('settings')->update([
            'agentComission' => $validated['agent_commission'],
            'distributorComission' => $validated['distributor_commission'],
            'updated_at' => now(),
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
            'updated_at' => now(), // Include this to track changes
        ]);

        return response()->json([
            'status' => 'success',
            'agent_id' => $agentId,
        ]);
    }

    // PagesController.php (ક્યાંક)
    public function toggleSetToMinimum(Request $request)
    {
        // અહીં settings table માં પ્રથમ record હોય તેવા فرض કરો, જો ઘણા ન હોય તો ID ની જરૂર પડે
        $setting = DB::table('settings')->first();

        if (!$setting) {
            return response()->json(['error' => 'Settings not found'], 404);
        }

        $newValue = !$setting->setTominimum;

        DB::table('settings')->update([
            'setTominimum' => $newValue,
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'setTominimum' => $newValue,
        ]);
    }

    public function standingToEarning(Request $request)
    {
        // છેલ્લો inserted settings record લો
        $setting = DB::table('settings')->latest('id')->first();

        if (!$setting) {
            return redirect()->back()->with('error', 'No settings record found.');
        }

        // નવા earning ની ગણતરી
        $newEarning = $setting->earning + $setting->standing;

        // Update earning અને standing બંને
        DB::table('settings')
            ->where('id', $setting->id)
            ->update([
                'earning' => $newEarning,
                'standing' => 0, // standing હવે 0 થાય
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Earning updated and standing set to 0.');
    }

    public function earningToZero(Request $request)
{
    // છેલ્લો inserted record fetch કરો
    $setting = DB::table('settings')->latest('id')->first();

    if (!$setting) {
        return redirect()->back()->with('error', 'No settings record found.');
    }

    // earning ને 0 કરો
    DB::table('settings')
        ->where('id', $setting->id)
        ->update([
            'earning' => 0,
            'updated_at' => now(),
        ]);

    return redirect()->back()->with('success', 'Earning set to 0 successfully.');
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
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="game_history_' . $player->player . '_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($player) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Time', 'Bet Amount', 'Win Amount', 'Net Result', 'Game Result', 'Bet Values']);

            foreach ($player->gameHistory as $entry) {
                $net = $entry['winpoint'] - $entry['playPoint'];
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
        $balanceField = 'endpoint'; // Default

        if ($user->role === 'player') {
            $transferTo = User::where('id', $user->agent_id)->first();
            $userType = 'Player';
            $balanceField = 'balance';
        } elseif ($user->role === 'agent') {
            $transferTo = User::where('id', $user->distributor_id)->first();
            $userType = 'Agent';
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
                'transfer_to' => 'required', // We'll handle validation manually
                'amount' => 'required|numeric|min:0.01',
                'type' => 'required|in:subtract,add',
                'is_admin_recipient' => 'sometimes|boolean', // New field to identify admin recipients
            ]);

            $transfer_by = User::findOrFail($validated['transfer_by']);
            $transfer_role = $transfer_by->role;

            // Determine allowed recipients and their models
            $allowedRecipients = [];
            $recipientModel = null;
            $isRecipientAdmin = $validated['is_admin_recipient'] ?? false;

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
                $transfer_to = Admin::findOrFail($validated['transfer_to']);
                $recipientRole = 'admin';
            } else {
                $transfer_to = User::findOrFail($validated['transfer_to']);
                $recipientRole = $transfer_to->role;
            }

            if (!in_array($recipientRole, $allowedRecipients)) {
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
            if (!$transfer_by->save() || !$transfer_to->save()) {
                throw new \Exception('Failed to save balances');
            }

            // Create transfer record with comma-separated allowed roles
            DB::connection('mongodb')->table('transfers')->insert([
                'transfer_by' => $transfer_by->id,
                'transfer_to' => $transfer_to->id,
                'transfer_to_model' => $isRecipientAdmin ? 'admin' : 'user',
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

    public function showTransferReport()
    {
        $user = auth('web')->user();   // from users table
        $admin = auth('admin')->user(); // from admins table

        if (!$user && !$admin) {
            return redirect()->route('login');
        }

        $query = DB::connection('mongodb')->table('transfers')->orderBy('created_at', 'desc');

        // If a normal user is logged in, restrict to their transfers
        if ($user) {
            $query->where('transfer_by', $user->id);
        }

        // If admin is logged in, show all transfers (no filtering)

        $transfers = $query->get();

        if ($transfers->isEmpty()) {
            return view('pages.transfer.report', compact('transfers'));
        }

        $allAdmins = Admin::all()->keyBy('_id');

        $userIds = $transfers->pluck('transfer_by')
            ->merge($transfers->pluck('transfer_to'))
            ->unique();

        $users = User::whereIn('_id', $userIds)->get()->keyBy('_id');

        foreach ($transfers as $transfer) {
            $transfer->agent_name = $users->get($transfer->transfer_by)?->player ?? 'N/A (User ID: ' . $transfer->transfer_by . ')';

            if ($allAdmins->has($transfer->transfer_to)) {
                $transfer->distributor_name = $allAdmins->get($transfer->transfer_to)->player ?? 'Admin (ID: ' . $transfer->transfer_to . ')';
            } else {
                $transfer->distributor_name = $users->get($transfer->transfer_to)?->player ?? 'N/A (ID: ' . $transfer->transfer_to . ')';
            }
        }

        return view('pages.transfer.report', compact('transfers'));
    }






}
