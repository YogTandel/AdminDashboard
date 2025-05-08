<?php
namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function agentList()
    {
        return view('pages.agentlist');
    }

    public function distributor()
    {
        return view('pages.distributor');
    }

    public function player()
    {
        return view('pages.player');
    }

    public function transactionreport()
    {
        return view('pages.transactionreport');
    }
}
