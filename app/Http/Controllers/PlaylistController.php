<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Services\SpotifyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PlaylistController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function edit($playlistId = null): Response
    {

        if($playlistId) {
            $userId = Auth::id();
            
            $playlist = Playlist::where('id', $playlistId)
            ->where('user_id', $userId)
            ->firstOrFail();
        }
        return Inertia::render('Playlist/edit', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'playlist' => $playlist ? $playlist->toArray() : null,
        ]);
    }
    public function index(): Response
    {
        return Inertia::render('Playlist/Index', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    public function getPlaylists(Request $request)
    {
        
        $user = Auth::user();
        $playlist = Playlist::all();
        if ($user && $user->playlists()->count() > 0) {
            $playlists = $user->playlists()->paginate(10);
            return response()->json($playlists);
        }
        else {
         return response()->json(['message' => 'You don\'t have any playlists yet.'], 200);
        }
        

         return response()->json($user);
    }

    
    public function createOrUpdate($playlistId = null): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        $userId = Auth::id();
    
        if ($playlistId) {
            $playlist = Playlist::where('id', $playlistId)
                ->where('user_id', $userId)
                ->first();
    
            if (!$playlist) {
                return response()->json(['error' => 'Playlist not found or does not belong to the user'], 404);
            }
        } else {
            $defaultName = 'New Playlist ' . now()->format('YmdHis');
            $playlist = Playlist::create(['name' => $defaultName, 'user_id' => $userId]);
        }
    
        return response()->json($playlist);
    }

    public function addSong(Request $request, Playlist $playlist, Song $song): JsonResponse
    {
        try {
            // Attach the song to the playlist if it's not already attached
            if (!$playlist->songs()->where('song_id', $song->id)->exists()) {
                $playlist->songs()->attach($song->id);
                return response()->json(['message' => 'Song added to playlist successfully'], 200);
            } else {
                return response()->json(['message' => 'Song is already in this playlist'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add song to playlist', 'details' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        $query   = $request->input('q');
        $results = $this->spotifyService->searchPlaylists($query);
        return response()->json($results);
    }

    public function show(string $id)
    {
        $playlist = $this->spotifyService->getPlaylistById($id);
        // ...
    }
    
}