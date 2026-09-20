<?php

use App\Http\Controllers\Admin\MediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de administración (más adelante se protegerán con login).
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
});