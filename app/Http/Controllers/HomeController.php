<?php

namespace App\Http\Controllers;

use App\Models\VersionControl;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home(): View
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
        // If this version is being enabled, disable all others first
        if ($request->enabled === "1") {
            VersionControl::where('enabled', true)->update(['enabled' => false]);
        }

        VersionControl::create([
            'version' => $request->version,
            'code' => $request->code,
            'url' => $request->url,
            'enabled' => $request->enabled === "1" ? true : false,
        ]);

        return response()->json(['status' => true]);
    }

    public function versionControlEdit(Request $request)
    {
        // If this version is being enabled, disable all others first
        if ($request->enabled === "1") {
            VersionControl::where('enabled', true)->update(['enabled' => false]);
        }

        VersionControl::where('_id', $request->id)->update([
            'version' => $request->version,
            'code' => $request->code,
            'url' => $request->url,
            'enabled' => $request->enabled === "1" ? true : false,
        ]);

        return response()->json(['status' => true]);
    }
}
