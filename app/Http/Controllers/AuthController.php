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
            'password'    => 'required|string|min:6',
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
        $validate = $request->validate([
            'player'   => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:distributor',
            'status'   => 'required|in:Active,Inactive',
            'endpoint' => 'nullable|numeric|min:0',
        ]);

        $validate['original_password'] = $validate['password'];
        $validate['password']          = bcrypt($validate['password']);
        $validate['DateOfCreation']    = now()->format('YmdHis');

        $user = User::create($validate);

        Auth::login($user);

        return redirect()->route('distributor.show')->with('success', 'Agent added successfully');
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
