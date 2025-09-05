<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use MongoDB\BSON\ObjectId;

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

    public function showAdminLogin()
    {
        return view('auth.admin_login');
    }

    public function showChangePassword()
    {
        return view("auth.changepassword");
    }

    public function createAgent(Request $request)
    {
        Log::info('Attempting to create a new agent', ['input' => $request->except(['password', 'original_password'])]);

        $validate = $request->validate([
            'player'         => 'required|string|max:255|unique:users,player',
            'password'       => 'required|string|min:3',
            'role'           => 'required|in:agent',
            'endpoint'       => 'required|numeric|min:0',
            'distributor_id' => 'required|string',
            'distributor'    => 'required|string|max:255',
            'status'         => 'required|in:Active,Inactive',
        ]);

        try {
            // Cast distributor_id to MongoDB ObjectId before saving
            $validate['distributor_id'] = new ObjectId($validate['distributor_id']);

            $validate['original_password'] = $validate['password'];
            $validate['password']          = bcrypt($validate['password']);
            $validate['DateOfCreation']    = (float) now()->format('YmdHis');
            $validate['endpoint']          = (float) $validate['endpoint'];

            // Create the user document in MongoDB
            $user = User::create($validate);

            if ($user) {
                Log::info('Agent inserted', ['id' => $user->_id ?? $user->id]);
                return redirect()->route('agentlist.show')->with('success', 'Agent added successfully');
            } else {
                Log::warning('Agent creation returned null');
                return back()->withErrors(['error' => 'Creation returned null']);
            }

        } catch (\Exception $e) {
            Log::error('Failed to create agent', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to create agent. Please try again.']);
        }
    }

    public function createDistributor(Request $request)
    {
        Log::info('Attempting to create a new Distributor', [
            'input' => $request->except(['password', 'original_password']),
        ]);

        $validate = $request->validate([
            'player'   => 'required|string|max:255|unique:users,player',
            'password' => 'required|string|min:3',
            'role'     => 'required|in:distributor',
            'status'   => 'required|in:Active,Inactive',
            'endpoint' => 'required|numeric|min:0',
        ]);

        try {
            $validate['original_password'] = $validate['password'];
            $validate['password']          = bcrypt($validate['password']);

            $validate['DateOfCreation'] = (float) now()->format('YmdHis');
            $validate['endpoint']       = (float) $validate['endpoint'];

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
        Log::info('Attempting to create a new player', [
            'input' => $request->except(['password', 'original_password']),
        ]);

        $validate = $request->validate([
            'player'      => 'required|string|max:255|unique:users,player',
            'password'    => 'required|string|min:3',
            'role'        => 'required|in:player',
            'balance'     => 'numeric|min:0',
            'distributor' => 'required|exists:users,id',
            'agent'       => 'required|string|max:255',
            'agent_id'    => 'required|string',
            'status'      => 'required|in:Active,Inactive',
            'gameHistory' => 'nullable|array',
        ]);

        try {
            // Convert agent_id to ObjectId
            $validate['agent_id'] = new ObjectId($validate['agent_id']);

            // Set system-level fields
            $validate['original_password'] = $validate['password'];
            $validate['password']          = bcrypt($validate['password']);
            $validate['DateOfCreation']    = (float) now()->format('YmdHis');
            //set balance to 0
            $validate['balance'] = 0;

            // ✅ Set default login_status as false
            $validate['login_status'] = false;

            // ✅ Set default winamount as 0
            $validate['winamount'] = 0;

            $user = User::create($validate);

            if ($user) {
                Log::info('Player created successfully', ['id' => $user->_id ?? $user->id]);
                return redirect()->route('player.show')->with('success', 'Player added successfully');
            } else {
                Log::warning('Player creation returned null');
                return back()->withErrors(['error' => 'Creation returned null']);
            }

        } catch (\Exception $e) {
            Log::error('Failed to create player', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to create player. Please try again.']);
        }
    }

    public function editAgent(Request $request, $id)
    {
        Log::info('Attempting to edit agent', ['id' => $id]);

        $validate = $request->validate([
            'player'   => 'required|string|max:255|unique:users,player,' . $id,
            'password' => 'nullable|string|min:3',
            'role'     => 'required|in:agent',
            'endpoint' => 'required|numeric|min:0',
            'status'   => 'required|in:Active,Inactive',
            'per_page' => 'sometimes|numeric', // Add validation for per_page
        ]);

        try {
            $user                 = User::findOrFail($id);
            $validate['endpoint'] = (float) $validate['endpoint'];

            if (! empty($validate['password'])) {
                $validate['original_password'] = $validate['password'];
                $validate['password']          = bcrypt($validate['password']);
            } else {
                unset($validate['password']);
            }

            $user->update($validate);

            if ($validate['status'] == "Inactive") {
                User::where('agent_id', $id)->update(['status' => 'Inactive']);
            }

            Log::info('Agent updated', ['id' => $user->id]);

            // Redirect with all original query parameters including per_page
            return redirect()->route('agentlist.show', [
                'per_page' => $request->per_page ?? 10,
                'search'   => $request->session()->get('search'), // Preserve search if needed
                                                                  // Add any other parameters you need to preserve
            ])->with('success', 'Agent updated successfully');

        } catch (\Exception $e) {
            Log::error('Failed to update agent', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to update agent. Please try again.'])
                ->withInput($request->all()); // Preserve all input including per_page
        }
    }

    public function editDistributor(Request $request, $id)
    {
        Log::info('Attempting to edit distributor', ['id' => $id]);

        $validate = $request->validate([
            'player'   => 'required|string|max:255|unique:users,player,' . $id,
            'password' => 'nullable|string|min:3',
            'role'     => 'required|in:distributor',
            'status'   => 'required|in:Active,Inactive',
            'endpoint' => 'required|numeric|min:0',
            'per_page' => 'sometimes|numeric', // Add validation for per_page
        ]);

        try {
            $user = User::findOrFail($id);

            if (! empty($validate['password'])) {
                $validate['original_password'] = $validate['password'];
                $validate['password']          = bcrypt($validate['password']);
            } else {
                unset($validate['password']);
            }
            $validate['endpoint'] = (float) $validate['endpoint'];

            $user->update($validate);

            if ($validate['status'] == "Inactive") {
                User::where('distributor', $id)->update(['status' => 'Inactive']);
            }

            Log::info('Distributor updated', ['id' => $user->id]);

            // Redirect with all original query parameters
            return redirect()->route('distributor.show', [
                'per_page' => $request->per_page ?? 10,
                'search'   => $request->search ?? null,
                // Add any other parameters you need to preserve
            ])->with('success', 'Distributor updated successfully');

        } catch (\Exception $e) {
            Log::error('Failed to update distributor', ['id' => $id, 'error' => $e->getMessage()]);
            return back()
                ->withErrors(['error' => 'Failed to update distributor. Please try again.'])
                ->withInput($request->all()); // Preserve all input including per_page
        }
    }
    public function editPlayer(Request $request, $id)
    {
        Log::info('Attempting to edit player', ['id' => $id]);

        // Validate request (winamount removed)
        $validate = $request->validate([
            'player'      => 'required|string|max:255|unique:users,player,' . $id,
            'password'    => 'nullable|string|min:3',
            'role'        => 'required|in:player',
            'status'      => 'required|in:Active,Inactive',
            'gameHistory' => 'nullable|array',
        ]);

        try {
            // Find the user
            $user = User::findOrFail($id);

            // Optional password update
            if (! empty($validate['password'])) {
                $validate['original_password'] = $validate['password'];
                $validate['password']          = bcrypt($validate['password']);
            } else {
                unset($validate['password']);
            }
            // Preserve winamount from existing record
            $validate['winamount'] = isset($user->winamount) ? (int) $user->winamount : 0;

            // Update user
            $user->update($validate);

            Log::info('Player updated successfully', ['id' => $user->_id ?? $user->id]);
            return redirect()->route('player.show')->with('success', 'Player updated successfully');

        } catch (\Exception $e) {
            Log::error('Failed to update player', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors(['error' => 'Failed to update player. Please try again.']);
        }
    }

    public function deleteAgent($id)
    {
        $agent = User::where('id', $id)->where('role', 'agent')->firstOrFail();
        $agent->forceDelete();
        User::where('agent_id', $id)
            ->update(['status' => 'Inactive']);
        return redirect()->route('agentlist.show')->with('success', 'Agent deleted successfully');
    }

    public function deleteDistributor($id)
    {

        $distributor = User::where('id', $id)->where('role', 'distributor')->firstOrFail();
        $distributor->forceDelete();

        User::where('distributor', $id)
            ->update(['status' => 'Inactive']);

        return redirect()->route('distributor.show')->with('success', 'Distributor deleted successfully and agents deactivated.');
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

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|confirmed',
        ]);

        // Determine which guard is authenticated
        if (Auth::guard('admin')->check()) {
            $user  = Auth::guard('admin')->user();
            $guard = 'admin';
        } else {
            $user  = Auth::guard('web')->user();
            $guard = 'web';
        }

        // Check current password validity
        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }
        $user->original_password = $request->new_password;

        // Update hashed password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Logout user from the correct guard
        Auth::guard($guard)->logout();

        return redirect()->route('show.login')->with('success', 'Password updated successfully. Please login again.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('show.login')->with('success', 'Logout successful!');
    }
}
