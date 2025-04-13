<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlaylistController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('spotify')->group(function () {
        Route::get('/songs/search', [SongController::class, 'searchSongs']);
        Route::get('/playlists', [PlaylistController::class, 'index']);
        Route::get('/playlists/{playlist}', [PlaylistController::class, 'show']);
        Route::get('/playlists/search', [PlaylistController::class, 'searchSpotify']);
        Route::post('/playlists/import', [PlaylistController::class, 'importSpotifyPlaylist']);
        Route::get('/get/tracks', [SongController::class, 'getTrendTracks']);
        
    });
    
});

require __DIR__.'/auth.php';
