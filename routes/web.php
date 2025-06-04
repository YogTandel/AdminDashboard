<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('show.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

//agent
Route::get('/agentlist', [PagesController::class, 'agentList'])->name('agentlist.show');
Route::post('/agentlist/store', [AuthController::class, 'createAgent'])->name('agent.add');
Route::put('/agentlist/{id}/update', [AuthController::class, 'editAgent'])->name('agent.update');
Route::delete('/agentlist/{id}/delete', [AuthController::class, 'deleteAgent'])->name('agent.delete');
Route::post('/select-agent', [PagesController::class, 'selectAgent'])->name('agent.select');
Route::post('/agent/deselect', [PagesController::class, 'deselect'])->name('agent.deselect');

//distributor
Route::get('/distributor', [PagesController::class, 'distributor'])->name('distributor.show');
Route::post('/distributor/store', [AuthController::class, 'createDistributor'])->name('distributor.add');
Route::put('/distributor/{id}/update', [AuthController::class, 'editDistributor'])->name('distributor.update');
Route::delete('/distributor/{id}/delete', [AuthController::class, 'deleteDistributor'])->name('Distributor.delete');

//player
Route::get('/player', [PagesController::class, 'player'])->name('player.show');
Route::post('/player/store', [AuthController::class, 'createplayer'])->name('player.add');
Route::put('/player/{id}/update', [AuthController::class, 'editPlayer'])->name('player.update');
Route::delete('/player/{id}/delete', [AuthController::class, 'deleteplayer'])->name('player.delete');
Route::get('/players/{playerId}/export-history', [PagesController::class, 'exportGameHistory'])->name('export.game.history');
Route::get('/players/{id}/history', [PagesController::class, 'playerHistory'])->name('player.history');

// transaction report
Route::get('/transactionreport', [PagesController::class, 'transactionreport'])->name('transactionreport');

// setting
Route::get('/setting', [PagesController::class, 'setting'])->name('setting');
Route::post('/settings/update-commissions', [PagesController::class, 'updateCommissions'])->name('settings.updateCommissions');

// live game
Route::get('/livegame', [PagesController::class, 'livegame'])->name('livegame');

// transfer
Route::get('/transfer/login', [PagesController::class, 'transferForm'])->name('transfer.form');

// test-db
Route::get('/test-db', function () {
    return DB::connection('mongodb')->collection('test')->insert(['hello' => 'world']);
});

// test-player
Route::get('/test-player', function () {
    $player = User::where('player', 'zeeshan')->first();
    dd($player->gameHistory);
});
