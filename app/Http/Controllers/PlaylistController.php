<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }
    public function index(Request $request)
    {
        
        $user = Auth::user();
        $playlist = Playlist::all();
        if ($user && $user->playlists()->count() > 0) {
            $playlists = $user->playlists()->paginate(10);
        }
        else {
         return response()->json(['message' => 'You don\'t have any playlists yet.'], 200);
        }
        

         return response()->json($user);
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