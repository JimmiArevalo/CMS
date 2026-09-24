<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Todas las rutas de este archivo llevan el prefijo /api.
// Los nombres empiezan por "api." para no chocar con las rutas web.
Route::name('api.')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'me'])->name('profile');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});