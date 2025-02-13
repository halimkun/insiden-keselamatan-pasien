<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

///  Dashboard
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

///  Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('master', function () {
        return view('master-data.index');
    })->name('data.master');

    ///  User
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::get('users/{id}/roles', [\App\Http\Controllers\UserController::class, 'roles'])->name('users.roles');
    Route::post('users/{id}/restore', [\App\Http\Controllers\UserController::class, 'restore'])->name('users.restore');

    Route::post('users/{id}/set-role', [\App\Http\Controllers\UserController::class, 'setRoles'])->name('users.set-roles');
    Route::patch('users/{id}/set-password', [\App\Http\Controllers\UserController::class, 'setPassword'])->name('users.set-password');
    Route::post('users/{id}/set-permission', [\App\Http\Controllers\UserController::class, 'setPermission'])->name('users.set-permissions');

    ///  Master Data
    Route::group(['prefix' => 'master'], function () {
        Route::resource('unit', \App\Http\Controllers\UnitController::class);
        Route::resource('jenis-insiden', \App\Http\Controllers\JenisInsidenController::class);
        Route::resource('penanggung-biaya', \App\Http\Controllers\PenanggungBiayaController::class);
        Route::resource('jabatan', \App\Http\Controllers\JabatanController::class);
    });

    ///  Pasien
    Route::resource('pasien', \App\Http\Controllers\PasienController::class);
    Route::post('pasien/{id}/restore', [\App\Http\Controllers\PasienController::class, 'restore'])->name('pasien.restore');

    ///  Insiden
    Route::get('/insiden/export', [\App\Http\Controllers\ExportInsidenController::class, 'index'])->name('insiden.export');
    
    Route::resource('insiden', \App\Http\Controllers\InsidenController::class);
    Route::post('insiden/get/terkait', [\App\Http\Controllers\InsidenController::class, 'getInsidenTerkait'])->name('insiden.get-terkait');
    Route::post('insiden/{insiden}/ttd', [\App\Http\Controllers\InsidenController::class, 'ttd'])->name('insiden.ttd');
    Route::get('insiden/{insiden}/print', [\App\Http\Controllers\InsidenController::class, 'print'])->name('insiden.print');
    Route::get('insiden/{insiden}/pdf', [\App\Http\Controllers\InsidenController::class, 'pdf'])->name('insiden.pdf');
    
    // Investigasi
    // Route::resource('investigasi', \App\Http\Controllers\InvestigasiController::class)->only(['index']);
    // Route::resource('insiden.investigasi', \App\Http\Controllers\InvestigasiController::class)->except(['index']);

    ///  Grading
    Route::resource('grading', \App\Http\Controllers\GradingController::class)->only(['show', 'store']);
    Route::post('grading/by-data', [\App\Http\Controllers\GradingController::class, 'getGradingByData'])->name('grading.by-data');

    ///  Role & Setting
    Route::resource('roles', \App\Http\Controllers\RoleAndPermissionController::class);
    Route::resource('settings', \App\Http\Controllers\SettingController::class);
});


///  DataTables
Route::prefix('datatables')->group(function () {
    Route::get('/users', [\App\Http\Controllers\DataTables\UserController::class, 'index'])->name('datatables.users');
    Route::get('/insiden', [\App\Http\Controllers\DataTables\InsidenController::class, 'index'])->name('datatables.insiden');
    Route::get('/units', [\App\Http\Controllers\DataTables\UnitController::class, 'index'])->name('datatables.units');
    Route::get('/pasien', [\App\Http\Controllers\DataTables\PasienController::class, 'index'])->name('datatables.pasien');
    Route::get('/jenis-insiden', [\App\Http\Controllers\DataTables\JenisInsidenController::class, 'index'])->name('datatables.jenis-insiden');
    Route::get('/penanggung-biaya', [\App\Http\Controllers\DataTables\PenanggungBiayaController::class, 'index'])->name('datatables.penanggung-biaya');
    Route::get('/investigasi', [\App\Http\Controllers\DataTables\InvestigasiController::class, 'index'])->name('datatables.investigasi');
});

require __DIR__ . '/auth.php';
