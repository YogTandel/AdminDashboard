<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function register(Request $request)
    {
        $validate = $request->validate([
            'player'         => 'required|string|max:255',
            'password'       => 'required|string|min:6',
            'role'           => 'required|in:admin,distributor,agent',
            'agent'          => 'required|string|max:255',
            'distributor'    => 'required|string|max:255',
            'distributor_id' => 'required|exists:users,id',
            'agent_id'       => 'required|exists:users,id',
        ]);

        $validate['DateOfCreation'] = now()->format('YmdHis');
        $validate['balance']        = 0;
        $validate['gameHistory']    = [];
        $validate['isupdated']      = false;
        $validate['status']         = 'Active';
        $validate['login_status']   = false;
        $validate['endpoint']       = 0;
        $validate['winamount']      = 0;

        $user = User::create($validate);

        Auth::login($user);

        return redirect()->route('show.login')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'player'   => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,distributor,agent',
        ]);

        // Only pass player and password to Auth::attempt()
        if (Auth::attempt([
            'player'   => $credentials['player'],
            'password' => $credentials['password'],
            'status'   => 'Active',
        ])) {
            $request->session()->regenerate();

            if (Auth::user()->role !== $credentials['role']) {
                Auth::logout();
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
