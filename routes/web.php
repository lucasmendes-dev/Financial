<?php

use App\Http\Controllers\Accounts\AccountController;
use App\Http\Controllers\Assets\AssetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
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

Route::middleware('auth')->group(function () {
    //Asset routes
    Route::delete('/assets/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');
    Route::get('/assets/edit/{id}', [AssetController::class, 'edit'])->name('assets.edit');
    Route::put('/assets/{id}', [AssetController::class, 'update'])->name('assets.update');
    Route::put('/assets/contribuition/{id}', [AssetController::class, 'newContribuition'])->name('assets.contribuition');
    Route::post('/assets/store', [AssetController::class, 'store'])->name('assets.store');
    Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
    Route::get('/assets/show/{id}', [AssetController::class, 'show'])->name('assets.show');
    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('/assets/detailedView', [AssetController::class, 'detailedView'])->name('assets.detailedView');

    Route::get('/assets/reloadData', [AssetController::class, 'reloadData'])->name('assets.reloadData');

    //Account routes
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
    Route::get('/accounts/edit/{id}', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
    Route::post('/accounts/store', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::get('/accounts/show/{id}', [AccountController::class, 'show'])->name('accounts.show');
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
});
