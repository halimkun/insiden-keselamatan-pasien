<?php

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


Route::middleware('auth')->group(function () {
    Route::get('master', function () {
        return view('master-data.index');
    })->name('data.master');
    
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::post('users/{id}/restore', [\App\Http\Controllers\UserController::class, 'restore'])->name('users.restore');
    
    Route::group(['prefix'=> 'master'], function () {
        Route::resource('unit', \App\Http\Controllers\UnitController::class);
        Route::resource('jenis-insiden', \App\Http\Controllers\JenisInsidenController::class);
        Route::resource('penanggung-biaya', \App\Http\Controllers\PenanggungBiayaController::class);
    });
});


// Datatables
Route::prefix('datatables')->group(function () {
    Route::get('/users', [\App\Http\Controllers\DataTables\UserController::class, 'index'])->name('datatables.users');
    Route::get('/units', [\App\Http\Controllers\DataTables\UnitController::class, 'index'])->name('datatables.units');
    Route::get('/jenis-insiden', [\App\Http\Controllers\DataTables\JenisInsidenController::class, 'index'])->name('datatables.jenis-insiden');
    Route::get('/penanggung-biaya', [\App\Http\Controllers\DataTables\PenanggungBiayaController::class, 'index'])->name('datatables.penanggung-biaya');
});

require __DIR__ . '/auth.php';
