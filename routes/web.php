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
    Route::get('users/{id}/roles', [\App\Http\Controllers\UserController::class, 'roles'])->name('users.roles');
    Route::post('users/{id}/restore', [\App\Http\Controllers\UserController::class, 'restore'])->name('users.restore');

    Route::post('users/{id}/set-role', [\App\Http\Controllers\UserController::class, 'setRoles'])->name('users.set-roles');
    Route::patch('users/{id}/set-password', [\App\Http\Controllers\UserController::class, 'setPassword'])->name('users.set-password');
    Route::post('users/{id}/set-permission', [\App\Http\Controllers\UserController::class, 'setPermission'])->name('users.set-permissions');

    Route::group(['prefix'=> 'master'], function () {
        Route::resource('unit', \App\Http\Controllers\UnitController::class);
        Route::resource('jenis-insiden', \App\Http\Controllers\JenisInsidenController::class);
        Route::resource('penanggung-biaya', \App\Http\Controllers\PenanggungBiayaController::class);
    });

    Route::resource('pasien', \App\Http\Controllers\PasienController::class);
    Route::post('pasien/{id}/restore', [\App\Http\Controllers\PasienController::class, 'restore'])->name('pasien.restore');

    Route::resource('insiden', \App\Http\Controllers\InsidenController::class);
    Route::resource('grading', \App\Http\Controllers\GradingController::class)->only(['show', 'store']);
    Route::resource('roles', \App\Http\Controllers\RoleAndPermissionController::class);
});


// Datatables
Route::prefix('datatables')->group(function () {
    Route::get('/users', [\App\Http\Controllers\DataTables\UserController::class, 'index'])->name('datatables.users');
    Route::get('/insiden', [\App\Http\Controllers\DataTables\InsidenController::class, 'index'])->name('datatables.insiden');
    Route::get('/units', [\App\Http\Controllers\DataTables\UnitController::class, 'index'])->name('datatables.units');
    Route::get('/pasien', [\App\Http\Controllers\DataTables\PasienController::class, 'index'])->name('datatables.pasien');
    Route::get('/jenis-insiden', [\App\Http\Controllers\DataTables\JenisInsidenController::class, 'index'])->name('datatables.jenis-insiden');
    Route::get('/penanggung-biaya', [\App\Http\Controllers\DataTables\PenanggungBiayaController::class, 'index'])->name('datatables.penanggung-biaya');
});

require __DIR__ . '/auth.php';
