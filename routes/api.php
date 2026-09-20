<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Todas las rutas de este archivo llevan el prefijo /api.
// Los nombres empiezan por "api." para no chocar con las rutas web.
Route::name('api.')->group(function () {

    // Público: máximo 5 intentos por minuto.
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login');

    // Requieren un token válido en la cabecera Authorization.
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});