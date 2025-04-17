<?php

namespace App\Http\Controllers;


use App\Models\Song;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Services\SpotifyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlaylistController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
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
        $perPge = request('per_page') ?? 8 ;
        $user = Auth::user();
        $playlist = Playlist::all();
        if ($user && $user->playlists()->count() > 0) {
            $playlists = $user->playlists()->paginate($perPge);

            return response()->json($playlists);
        }
        else {
         return response()->json(['message' => 'You don\'t have any playlists yet.'], 200);
        }
        

         return response()->json($user);
    }
    public function edit($playlistId = null): Response
    {
        
        if($playlistId) {
            $userId = Auth::id();
            
            $playlist = Playlist::where('id', $playlistId)
            ->where('user_id', $userId)
            ->firstOrFail();
        }
        return Inertia::render('Playlist/Edit', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'playlist' => $playlist ? $playlist->toArray() : null,
        ]);
    }

    
    public function createOrUpdate($playlistId = null)
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
    
        //return response()->json($playlist);
        return redirect()->route('playlist.edit', ['playlistId' => $playlist->id])
        ->with('success', 'Playlist created successfully!');
    }

    public function addSong(Request $request, Playlist $playlist, SpotifyService $spotifyService, $playlistId): JsonResponse
    {
        try {
 
            $spotifyTrackId = $request->input('selected_song_id');
    
            if (!$spotifyTrackId) {
                return response()->json(['error' => 'Missing selected_song_id in the request'], 400);
            }
    
            $spotifyTrack = $spotifyService->getTrack($spotifyTrackId); 
    
            if (!$spotifyTrack) {
                return response()->json(['error' => 'Track not found on Spotify'], 404);
            }
    

            $song = Song::where('spotify_id', $spotifyTrack['id'])->first();
    
            if (!$song) {
 
                $song = Song::create([
                    'spotify_id'   => $spotifyTrack['id'],
                    'name'         => $spotifyTrack['name'] ?? null,
                    'artist'       => implode(', ', array_column($spotifyTrack['artists'], 'name')) ?? null,
                    'album'        => $spotifyTrack['album']['name'] ?? null,
                    'duration_ms'  => $spotifyTrack['duration_ms'] ?? null,
                    'release_year' => substr($spotifyTrack['album']['release_date'], 0, 4) ?? null,
                 ]);
                    Log::info('New song created', ['id' => $song->id, 'name' => $song->name]);
                } else {
                   
            }
    
            // Attach the song to the playlist if it's not already attached
            $playlist = Playlist::findOrFail($playlistId);

            if (!$playlist->songs()->where('song_id', $song->id)->exists()) {
                $playlist->songs()->attach($song->id);
                return response()->json(['message' => 'Song added to playlist successfully'], 200);
            } else {
                return response()->json(['message' => 'Song is already in this playlist'], 200);
            }
    
        } catch (\Exception $e) {

            Log::error('Error adding song to playlist: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to add song to playlist', 'details' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
      //
      
    }

    public function show(string $playlistId) : JsonResponse
    {

        $playlist =Playlist::with('songs')->findOrFail($playlistId);
        
        return response()->json($playlist);

    }

    public function destroy(string $playlistId): RedirectResponse
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        $userId = Auth::id();
        
        $playlist = Playlist::where('id', $playlistId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $playlist->delete();

        return redirect()->route('playlists.index')->with('success', 'Playlist deleted successfully.');
    }

    public function destroySong( string $playlistId, string $songId)
    {

        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        $userId = Auth::id();
        $playlist = Playlist::where('id', $playlistId)->where('user_id', $userId)->firstOrFail();
        
        try {
            if($playlist) {
                $playlist->songs()->detach($songId);
                return redirect()->route('playlists.index')->with('success', 'Playlist deleted successfully.');
            }
            else {
                return response()->json('there is no playlist');
            }
            
        }
        
        catch (\Exception $e) {

            Log::error('Error delete song : ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete song in playlist', 'details' => $e->getMessage()], 500);

        }
      
 
    }
    

}