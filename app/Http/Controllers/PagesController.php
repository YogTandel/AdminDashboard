<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function agentList()
    {
        $agents = User::where('role', 'agent')->get();
        return view('pages.agentlist', compact('agents'));
    }

   /*  public function createAgent()
    {
        $agents = User::where('role', 'agent')->get();
        return view('pages.createagent', compact('agents'));
    } */

    public function distributor()
    {
        $distributors = User::where('role', 'distributor')->get();
        return view('pages.distributor', compact('distributors'));
    }

    public function createdistributor()
    {
        $distributors = User::where('role', 'distributor')->get();
        return view('pages.creatdistributor', compact('distributors'));
    }

    public function addDistributor(Request $request)
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

    public function player()
    {
        $players = User::where('role', 'player')->get();
        return view('pages.player', compact('players'));
    }

    public function transactionreport()
    {
        return view('pages.transactionreport');
    }

    public function setting()
    {
        return view('pages.setting');
    }

    public function liveGame()
    {
        return view('pages.livegame');
    }
}
