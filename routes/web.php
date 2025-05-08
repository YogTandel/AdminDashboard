<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('show.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

Route::get('/agentlist', [PagesController::class, 'agentList'])->name('agentlist');
Route::get('/distributor', [PagesController::class, 'distributor'])->name('distributor');
Route::get('/player', [PagesController::class, 'player'])->name('player');
Route::get('/transactionreport', [PagesController::class, 'transactionreport'])->name('transactionreport');
