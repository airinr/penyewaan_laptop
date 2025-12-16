<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PenyewaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('penyewaan');
    }
    
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Penyewaan
    Route::get('/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan');
    Route::get('/penyewaan/create', [PenyewaanController::class, 'create'])->name('penyewaan.create');
    Route::post('/penyewaan/store', [PenyewaanController::class, 'store'])->name('penyewaan.store');
    Route::put('/penyewaan/{id}/kembali', [PenyewaanController::class, 'kembali'])->name('penyewaan.kembali');

    // laptop
    Route::resource('laptop', LaptopController::class);

    // Penyewa  
    Route::resource('penyewa', PenyewaController::class);
});


require __DIR__.'/auth.php';
