<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\PumController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
   Route::get('/master/anggaran', [AnggaranController::class, 'index'])
       ->name('master.anggaran');
   Route::post('/master/anggaran', [AnggaranController::class, 'store'])
       ->name('master.anggaran.store');
   Route::put('/master/anggaran/{id}', [AnggaranController::class, 'update'])
       ->name('master.anggaran.update');
   Route::delete('/master/anggaran/{id}', [AnggaranController::class, 'destroy'])
       ->name('master.anggaran.destroy');
   Route::post('/master/anggaran/{id}/activate', [AnggaranController::class, 'activate'])
       ->name('master.anggaran.activate');
    
    // PUM Routes
    Route::prefix('pum')->name('pum.')->group(function () {
        Route::get('/input', [PumController::class, 'index'])->name('input');
        Route::post('/input', [PumController::class, 'store'])->name('store');
        Route::get('/history', [PumController::class, 'history'])->name('history');
        Route::get('/edit/{id}', [PumController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PumController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PumController::class, 'destroy'])->name('destroy');
    });
});
