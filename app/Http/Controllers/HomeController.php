<?php

namespace App\Http\Controllers;

use App\Models\VersionControl;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(): \Illuminate\View\View
    {
        return view('dashboard');
    }

    public function versionControl()
    {
        $versions = VersionControl::orderBy('_id', 'desc')->get();
        return view('pages.versioncontrol.index', compact('versions'));
    }

    public function versionControlAdd(Request $request)
    {
        VersionControl::create([
            'version' => $request->version,
            'code' => $request->code,
            'enabled' => $request->enabled === "1" ? true : false,
        ]);

        return response()->json(['status' => true]);
    }

    public function versionControlEdit(Request $request)
    {
        VersionControl::where('_id', $request->id)->update([
            'version' => $request->version,
            'code' => $request->code,
            'enabled' => $request->enabled === "1" ? true : false,
        ]);

        return response()->json(['status' => true]);
    }
}
