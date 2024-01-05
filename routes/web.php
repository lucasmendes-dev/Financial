<?php

use App\Http\Controllers\Assets\AssetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
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

//Asset routes

Route::delete('/assets/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');
Route::get('/assets/edit/{id}', [AssetController::class, 'edit'])->name('assets.edit');
Route::put('/assets/{id}', [AssetController::class, 'update'])->name('assets.update');
Route::post('/assets/store', [AssetController::class, 'store'])->name('assets.store');
Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
Route::get('/assets/show/{id}', [AssetController::class, 'show'])->name('assets.show');
Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');