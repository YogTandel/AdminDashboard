<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function createAgent(Request $request)
{
    Log::info('Attempting to create a new agent', ['input' => $request->except(['password', 'original_password'])]);

    $validate = $request->validate([
        'player'      => 'required|string|max:255|unique:users,player',
        'password'    => 'required|string|min:3',
        'role'        => 'required|in:agent',
        'agent'       => 'required|string|max:255',
        'endpoint'    => 'required|numeric|min:0',
        'distributor' => 'required|string|max:255',
        'balance'     => 'required|numeric|min:0',
        'status'      => 'required|in:Active,Inactive',
    ]);

    try {
        $validate['original_password'] = $validate['password'];
        $validate['password']          = bcrypt($validate['password']);

        // Store DateOfCreation as float
        $validate['DateOfCreation']    = (float) now()->format('YmdHis');
        $validate['balance']           = (float) $validate['balance'];
        $validate['endpoint']          = (int) $validate['endpoint'];

        $user = User::create($validate);

        if ($user) {
            Log::info('Agent inserted', ['id' => $user->_id ?? $user->id]);
        } else {
            Log::warning('Agent creation returned null');
        }

        return redirect()->route('agent.show')->with('success', 'Agent added successfully');
    } catch (\Exception $e) {
        Log::error('Failed to create agent', ['error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'Failed to create agent. Please try again.']);
    }
}

    public function createDistributor(Request $request)
    {
        // Log input (excluding sensitive fields)
        Log::info('Attempting to create a new Distributor', [
            'input' => $request->except(['password', 'original_password'])
        ]);

        // Validate input
        $validate = $request->validate([
            'player'   => 'required|string|max:255|unique:users,player',
            'password' => 'required|string|min:3',
            'role'     => 'required|in:distributor',
            'balance'  => 'required|numeric|min:0',
            'status'   => 'required|in:Active,Inactive',
            'endpoint' => 'required|numeric|min:0',
        ]);

        try {
            // Set additional fields
            $validate['original_password'] = $validate['password'];
            $validate['password'] = bcrypt($validate['password']);

            // 🕒 Store DateOfCreation as float (double) from YmdHis string
            $dateString = now()->format('YmdHis');        // e.g., "20250630144020"
            $validate['DateOfCreation'] = (float) $dateString;

            // ✅ Cast to correct types
            $validate['balance'] = (float) $validate['balance'];     // double
            $validate['endpoint'] = (int) $validate['endpoint'];     // integer

            // Create the user
            $user = User::create($validate);

            if ($user) {
                Log::info('Distributor inserted', ['id' => $user->_id ?? $user->id]);
            } else {
                Log::warning('Distributor creation returned null');
            }

            return redirect()->route('distributor.show')->with('success', 'Distributor added successfully');
        } catch (\Exception $e) {
            Log::error('Failed to create Distributor', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to create Distributor. Please try again.']);
        }
    }



 public function createplayer(Request $request)
{
    Log::info('Attempting to create a new Player', ['input' => $request->except(['password', 'original_password'])]);

    $validate = $request->validate([
        'player'       => 'required|string|max:255|unique:users,player',
        'password'     => 'required|string|min:3',
        'role'         => 'required|in:player',
        'balance'      => 'required|numeric|min:0',
        'distributor'  => 'required|string|max:255',
        'agent'        => 'required|string|max:255',
        'login_status' => 'required|in:True,False',
        'status'       => 'required|in:Active,Inactive',
        'winamount'    => 'required|numeric',
        'gameHistory'  => 'nullable|array',
    ]);

    try {
        $validate['original_password'] = $validate['password'];
        $validate['DateOfCreation'] = (float) now()->format('YmdHis');
        $validate['balance'] = (float) $validate['balance'];
        $validate['winamount'] = (float) $validate['winamount'];

        $user = User::create($validate);

        if ($user) {
            Log::info('Player inserted', ['id' => $user->_id ?? $user->id]);
            return redirect()->route('player.show')->with('success', 'Player added successfully');
        } else {
            Log::warning('Player creation returned null');
            return back()->withErrors(['error' => 'Creation returned null']);
        }

    } catch (\Exception $e) {
        Log::error('Failed to create Player', ['error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'Failed to create player. Please try again.']);
    }
}





    public function editAgent(Request $request, $id)
{
    Log::info('Attempting to edit agent', ['id' => $id]);

    $validate = $request->validate([
        'player'      => 'required|string|max:255|unique:users,player,' . $id,
        'password'    => 'nullable|string|min:3',
        'role'        => 'required|in:agent',
        'agent'       => 'required|string|max:255',
        'endpoint'    => 'required|numeric|min:0',
        'distributor' => 'required|string|max:255',
        'balance'     => 'required|numeric|min:0',
        'status'      => 'required|in:Active,Inactive',
    ]);

    try {
        $user = User::findOrFail($id);

        // ✅ Type casting to avoid BSON Decimal128 or string issues
        $validate['balance']  = (float) $validate['balance'];
        $validate['endpoint'] = (int) $validate['endpoint'];

        if (!empty($validate['password'])) {
            $validate['original_password'] = $validate['password'];
            $validate['password'] = bcrypt($validate['password']);
        } else {
            unset($validate['password']);
        }

        $user->update($validate);

        Log::info('Agent updated', ['id' => $user->id]);

        return redirect()->route('agentlist.show')->with('success', 'Agent updated successfully');
    } catch (\Exception $e) {
        Log::error('Failed to update agent', ['id' => $id, 'error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'Failed to update agent. Please try again.']);
    }
    }


    public function editDistributor(Request $request, $id)
{
    Log::info('Attempting to edit distributor', ['id' => $id]);

    // Validate input
    $validate = $request->validate([
        'player'   => 'required|string|max:255|unique:users,player,' . $id,
        'password' => 'nullable|string|min:3',
        'role'     => 'required|in:distributor',
        'balance'  => 'required|numeric|min:0',
        'status'   => 'required|in:Active,Inactive',
        'endpoint' => 'required|numeric|min:0',
    ]);

    try {
        $user = User::findOrFail($id);

        // Handle password separately
        if (!empty($validate['password'])) {
            $validate['original_password'] = $validate['password'];
            $validate['password'] = bcrypt($validate['password']);
        } else {
            unset($validate['password']);
        }

        // ✅ Cast to proper data types for MongoDB
        $validate['balance'] = (float) $validate['balance'];     // Ensure double
        $validate['endpoint'] = (int) $validate['endpoint'];     // Ensure integer

        // Optional: Update DateOfCreation if needed
        // $validate['DateOfCreation'] = (float) now()->format('YmdHis');

        // Update user
        $user->update($validate);

        Log::info('Distributor updated', ['id' => $user->id]);

        return redirect()->route('distributor.show')->with('success', 'Distributor updated successfully');
    } catch (\Exception $e) {
        Log::error('Failed to update distributor', ['id' => $id, 'error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'Failed to update distributor. Please try again.']);
    }
}


    public function editPlayer(Request $request, $id)
{
    Log::info('Attempting to edit player', ['id' => $id]);

    $validate = $request->validate([
        'player'      => 'required|string|max:255|unique:users,player,' . $id,
        'password'    => 'nullable|string|min:3',
        'role'        => 'required|in:player',
        'balance'     => 'required|numeric|min:0',
        'distributor' => 'required|string|max:255',
        'agent'       => 'required|string|max:255',
        'status'      => 'required|in:Active,Inactive',
        'winamount'   => 'required|numeric',
        'gameHistory' => 'nullable|array',
    ]);

    try {
        $user = User::findOrFail($id);

        // Password update logic
        if (!empty($validate['password'])) {
            $validate['original_password'] = $validate['password'];
            $validate['password'] = bcrypt($validate['password']);
        } else {
            unset($validate['password']);
        }

        // ✅ Ensure proper casting to avoid Mongo Decimal128 issues
        $validate['balance'] = (float) $validate['balance'];
        $validate['winamount'] = (float) $validate['winamount'];

        $user->update($validate);

        Log::info('Player updated successfully', ['id' => $user->id]);
        return redirect()->route('player.show')->with('success', 'Player updated successfully');
    } catch (\Exception $e) {
        Log::error('Failed to update player', [
            'id' => $id,
            'error' => $e->getMessage(),
        ]);
        return back()->withErrors(['error' => 'Failed to update player. Please try again.']);
    }
    }


    public function deleteAgent($id)
    {
        $agent = User::where('id', $id)->where('role', 'agent')->firstOrFail();
        $agent->forceDelete();
        return redirect()->route('agentlist.show')->with('success', 'Agent deleted successfully');
    }

    public function deleteDistributor($id)
    {
        $agent = User::where('id', $id)->where('role', 'distributor')->firstOrFail();
        $agent->forceDelete();
        return redirect()->route('distributor.show')->with('success', 'Distributor deleted successfully');
    }

    public function deleteplayer($id)
    {
        $player = User::where('id', $id)->where('role', 'player')->firstOrFail();
        $player->forceDelete();
        return redirect()->route('player.show')->with('success', 'player deleted successfully');
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('show.login')->with('success', 'Logout successful!');
    }
}
