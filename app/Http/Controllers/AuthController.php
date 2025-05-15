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
            'distributor' => 'required|string|max:255',
            'balance'     => 'required|numeric|min:0',
            'status'      => 'required|in:Active,Inactive',
        ]);

        try {
            $validate['original_password'] = $validate['password'];
            $validate['password']          = bcrypt($validate['password']);
            $validate['DateOfCreation']    = now()->format('YmdHis');

            $user = User::create($validate);

            if ($user) {
                Log::info('Agent inserted', ['id' => $user->_id ?? $user->id]);
            } else {
                Log::warning('Agent creation returned null');
            }

            return redirect()->route('agentlist.show')->with('success', 'Agent added successfully');
        } catch (\Exception $e) {
            Log::error('Failed to create agent', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to create agent. Please try again.']);
        }
    }

    public function createDistributor(Request $request)
    {
        Log::info('Attempting to create a new Distributor', ['input' => $request->except(['password', 'original_password'])]);

        $validate = $request->validate([
            'player'   => 'required|string|max:255|unique:users,player',
            'password' => 'required|string|min:3',
            'role'     => 'required|in:distributor',
            'balance'  => 'required|numeric|min:0',
            'status'   => 'required|in:Active,Inactive',
            'endpoint' => 'required|numeric|min:0',
        ]);

        try {
            $validate['original_password'] = $validate['password'];
            $validate['password']          = bcrypt($validate['password']);
            $validate['DateOfCreation']    = now()->format('YmdHis');

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
        Log::info('Attempting to create a new Distributor', ['input' => $request->except(['password', 'original_password'])]);

        $validate = $request->validate([
            'player'   => 'required|string|max:255|unique:users,player',
            'password' => 'required|string|min:3',
            'role'     => 'required|in:player',
            'balance'  => 'required|numeric|min:0',
            'distributor' => 'required|string|max:255',
            'agent'       => 'required|string|max:255',
            'status'   => 'required|in:Active,Inactive',
            'winamount'=>'required|numeric',
            'endpoint' => 'required|numeric|min:0',
        ]);

        try {
            $validate['original_password'] = $validate['password'];
            $validate['password']          = bcrypt($validate['password']);
            $validate['DateOfCreation']    = now()->format('YmdHis');

            $user = User::create($validate);

            if ($user) {
                Log::info('player inserted', ['id' => $user->_id ?? $user->id]);
            } else {
                Log::warning('player creation returned null');
            }

            return redirect()->route('player.show')->with('success', 'player added successfully');
        } catch (\Exception $e) {
            Log::error('Failed to create player', ['error' => $e->getMessage()]);
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
            'distributor' => 'required|string|max:255',
            'balance'     => 'required|numeric|min:0',
            'status'      => 'required|in:Active,Inactive',
        ]);

        try {
            $user = User::findOrFail($id);

            if (! empty($validate['password'])) {
                $validate['original_password'] = $validate['password'];
                $validate['password']          = bcrypt($validate['password']);
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

            if (! empty($validate['password'])) {
                $validate['original_password'] = $validate['password'];
                $validate['password']          = bcrypt($validate['password']);
            } else {
                unset($validate['password']);
            }

            $user->update($validate);

            Log::info('Distributor updated', ['id' => $user->id]);
            return redirect()->route('distributor.show')->with('success', 'Distributor updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update distributor', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to update distributor. Please try again.']);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'player'   => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,distributor,agent',
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
