<?php

use Inertia\Inertia;
use App\Models\Playlist;
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
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('spotify')->group(function () {
        
        Route::get('/songs/search', [SongController::class, 'searchSongs']);
        Route::get('/get/tracks', [SongController::class, 'getTrendTracks']);


        Route::get('/playlists/index', [PlaylistController::class, 'index'])->name('playlists.index');
        Route::get('/playlists/get/playlists', [PlaylistController::class, 'getPlaylists']);

        Route::get('/playlist/edit/{playlistId}', [PlaylistController::class, 'edit'])->name('playlist.edit');
        Route::post('/playlist/delete/{playlistId}', [PlaylistController::class, 'destroy']);
        Route::post('/playlist/create/{playlistId}', [PlaylistController::class, 'createOrUpdate']);
        
        Route::post('/playlists/{playlistId}/songs/{songId}/add', [PlaylistController::class, 'addSong'])->name('playlists.songs.add');
        Route::post('/playlists/{playlistId}/songs/{songId}/delete', [PlaylistController::class, 'destroySong'])->name('playlists.songs.destroy');


        Route::get('/playlists/show/{playlistId}', [PlaylistController::class, 'show'])->name('playlist');
        Route::get('/playlists/search', [PlaylistController::class, 'searchSpotify']);
        Route::post('/playlists/import', [PlaylistController::class, 'importSpotifyPlaylist']);

        
    });
    
});

require __DIR__.'/auth.php';
