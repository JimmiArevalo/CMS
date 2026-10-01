<?php

use App\Http\Controllers\Admin\AnimeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicAnimeController;
use App\Http\Controllers\PublicNewsController;
use Illuminate\Support\Facades\Route;

// Página principal (pública).
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contacto (público).
Route::get('/contacto', [ContactController::class, 'show'])->name('contact.show');

// Animes y géneros (público).
Route::get('/animes', [PublicAnimeController::class, 'index'])->name('anime.index');
Route::get('/animes/trending', [PublicAnimeController::class, 'trending'])->name('anime.trending');
Route::get('/animes/upcoming', [PublicAnimeController::class, 'upcoming'])->name('anime.upcoming');
Route::get('/animes/classics', [PublicAnimeController::class, 'classics'])->name('anime.classics');
Route::get('/animes/finished', [PublicAnimeController::class, 'finished'])->name('anime.finished');
Route::get('/animes/{slug}', [PublicAnimeController::class, 'show'])->name('anime.show');
Route::get('/generos', [PublicAnimeController::class, 'genres'])->name('genre.index');
Route::get('/generos/{slug}', [PublicAnimeController::class, 'byGenre'])->name('genre.show');

// Noticias (público).
Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

// Máximo 5 envíos por minuto por visitante, para evitar abuso del formulario.
Route::post('/contacto', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

// Login y registro: solo para visitantes sin sesión.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    // Máximo 5 intentos por minuto para frenar ataques de fuerza bruta.
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.attempt');

    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Administración: solo usuarios autenticados.
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Multimedia
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::put('/media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Animes
    Route::get('/anime', [AnimeController::class, 'index'])->name('anime.index');
    Route::get('/anime/create', [AnimeController::class, 'create'])->name('anime.create');
    Route::post('/anime', [AnimeController::class, 'store'])->name('anime.store');
    Route::get('/anime/{anime}/edit', [AnimeController::class, 'edit'])->name('anime.edit');
    Route::put('/anime/{anime}', [AnimeController::class, 'update'])->name('anime.update');
    Route::delete('/anime/{anime}', [AnimeController::class, 'destroy'])->name('anime.destroy');

    // Géneros
    Route::get('/genre', [GenreController::class, 'index'])->name('genre.index');
    Route::post('/genre', [GenreController::class, 'store'])->name('genre.store');
    Route::put('/genre/{genre}', [GenreController::class, 'update'])->name('genre.update');
    Route::delete('/genre/{genre}', [GenreController::class, 'destroy'])->name('genre.destroy');

    // Noticias
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

});