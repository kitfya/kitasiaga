<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KorbanController;
use App\Http\Controllers\LogistikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/lapor-bencana', [WelcomeController::class, 'store'])->name('lapor.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('korban', KorbanController::class)->except(['create', 'edit', 'show']);
    Route::resource('logistik', LogistikController::class)->except(['create', 'edit', 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
