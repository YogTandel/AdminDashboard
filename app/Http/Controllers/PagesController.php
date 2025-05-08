<?php
namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function agentList()
    {
        return view('pages.agentlist');
    }
}
