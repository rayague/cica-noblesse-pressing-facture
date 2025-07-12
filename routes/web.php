<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes pour la consultation client (sans authentification)
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/login', [ClientController::class, 'showLogin'])->name('login');
    Route::post('/login', [ClientController::class, 'login'])->name('login.post');
    Route::get('/factures', [ClientController::class, 'showFactures'])->name('factures');
    Route::get('/factures/{id}/download', [ClientController::class, 'downloadFacture'])->name('factures.download');
    Route::post('/logout', [ClientController::class, 'logout'])->name('logout');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
