<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('web')->prefix('pasien')->group(function () {
    Route::get('/search', 'App\Http\Controllers\Api\PasienController@search')->name('api.pasien.search');
    Route::post('/search', 'App\Http\Controllers\Api\PasienController@search')->name('api.pasien.search.post');
});