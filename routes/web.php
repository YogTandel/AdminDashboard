<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('show.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::get('/changepassword', [AuthController::class, 'showChangePassword'])->name('show.changepassword');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/change-password', [AuthController::class, 'changePassword'])
    ->name('change.password')
    ->middleware('auth');
Route::get('/login', function () {
    return redirect('/');
});

Route::get('/dashboard', [HomeController::class, 'home'])
    ->name('dashboard');

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
Route::delete('/distributor/{id}/delete', [AuthController::class, 'deleteDistributor'])->name('distributor.delete');

//player
Route::get('/players', [PagesController::class, 'player'])->name('player.show');
Route::post('/player/add', [AuthController::class, 'createplayer'])->name('player.add');
Route::put('/player/{id}/update', [AuthController::class, 'editPlayer'])->name('player.update');
Route::delete('/player/{id}/delete', [AuthController::class, 'deleteplayer'])->name('player.delete');
Route::get('/players/{playerId}/export-history', [PagesController::class, 'exportGameHistory'])->name('export.game.history');
Route::get('/players/{id}/history', [PagesController::class, 'playerHistory'])->name('player.history');

// transaction report
Route::get('/transactionreport', [PagesController::class, 'transactionreport'])->name('transactionreport');

// setting
Route::get('/setting', [PagesController::class, 'setting'])->name('setting');
Route::post('/settings/update-commissions', [PagesController::class, 'updateCommissions'])->name('settings.updateCommissions');
Route::post('/update-negative-agent', [PagesController::class, 'updateNegativeAgent']);
Route::post('/toggle-set-to-minimum', [PagesController::class, 'toggleSetToMinimum'])->name('toggle.setToMinimum');
Route::get('/setting', [PagesController::class, 'settings'])->name('setting');
Route::post('/settings/standing-to-earning', [PagesController::class, 'standingToEarning'])->name('settings.standingToEarning');
Route::post('/settings/earning-to-zero', [PagesController::class, 'earningToZero'])->name('settings.earningToZero');
Route::post('/settings/update-profit', [PagesController::class, 'updateProfit'])->name('settings.updateProfit');
Route::post('/admin/add-points', [PagesController::class, 'addPointsToAdmin'])->name('admin.addPoints');
Route::post('/admin/remove-points', [PagesController::class, 'removePointsFromAdmin'])->name('admin.removePoints');
Route::post('/custom-bet-update', [PagesController::class, 'updateCustomBet'])->name('custom.bet.update');
Route::get('/admin-endpoint', [PagesController::class, 'getAdminEndpoint'])->name('admin.endpoint');

// live game
Route::get('/livegame', [PagesController::class, 'livegame'])->name('livegame');
Route::get('/live-game-values', action: [PagesController::class, 'liveGamevalue'])->name('live.game.values');
Route::get('/bet-totals', [PagesController::class, 'getBetTotals'])->name('bet.totals');
Route::get('/get-live-players', [PagesController::class, 'getLivePlayers'])->name('players.live');

// transfer
Route::get('/transfer', [PagesController::class, 'transferForm'])->name('transfer.page');
Route::post('/transfer', [PagesController::class, 'processTransfer'])->name('transfer.execute');
Route::get('/transfer-report', [PagesController::class, 'showTransferReport'])->name('transfer.report');

// test-db
Route::get('/test-db', function () {
    return DB::connection('mongodb')->collection('test')->insert(['hello' => 'world']);
});

// test-player
Route::get('/test-player', function () {
    $player = User::where('player', 'zeeshan')->first();
    dd($player->gameHistory);
});

// web.php
Route::get('/get-agents/{distributorId}', [PagesController::class, 'getAgents']);

Route::get('/commission-report', [PagesController::class, 'commissionReport'])->name('commission.report');
// For fetching commission data using distributor ID
Route::get('/commission-report/{id}', [PagesController::class, 'commissionReportData']);

//transfer admin-distributor   distributor-agent    agent-player

Route::post('/admin/transfer-to-distributor', [PagesController::class, 'transferToDistributor'])
    ->name('admin.transfer.to.distributor');
Route::post('/distributor/transfer-to-agent', [PagesController::class, 'transferToAgent'])
    ->name('user.transfer.to.agent');
Route::post('/agent/transfer-to-player', [PagesController::class, 'transferToPlayer'])
    ->name('agent.transfer.to.player');

Route::get('/refil-report', [PagesController::class, 'showRefilReport'])->name('refil.report');

Route::get('/get-settings-data', [PagesController::class, 'getSettingsData'])->name('settings.data');

Route::get('/ajax/distributors', [PagesController::class, 'getDistributors']);

Route::get('/ajax/distributor/{id}', [PagesController::class, 'getDistributorDetails']);

Route::post('/release-commission', [PagesController::class, 'releaseCommission']);

Route::get('/commissionreport', [PagesController::class, 'relesecommissionReport'])->name('relesecommission-report');

Route::post('/distributor/status-update/{id}', [PagesController::class, 'updateStatus']);

Route::get('/dashboard', [PagesController::class, 'index'])->name('dashboard');

Route::post('/agent/toggle-status/{id}', [PagesController::class, 'toggleStatus'])->name('agent.toggleStatus');
Route::post('/distributor/toggle-status/{id}', [PagesController::class, 'distoggleStatus'])->name('distributor.toggleStatus');
Route::post('/player/toggle-status/{id}', [PagesController::class, 'playertoggleStatus'])->name('player.toggleStatus');

Route::get('/live-game-value', [PagesController::class, 'liveGamevalue']);


Route::get('/Weeklyreport', [PagesController::class, 'Weeklyreport'])->name('Weekly-report');
