<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpotifyService;

class SongController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function searchSongs(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['error' => 'Please provide a search query.'], 400);
        }

        $results = array_slice($this->spotifyService->searchTracks($query), 0, 12);
        
        return response()->json($results);
    }

    public function getTrendTracks() 
    
    {  
        // samples songs
        $trendsTracks = ['7ouMYWpwJ422jRcDASZB7P', '4VqPOruhp5EdPBeR92t6lQ', '2takcwOaAZWiXQijPHIx7B'];

        $results = $this->spotifyService->getTracks($trendsTracks);

        return response()->json($results);

    }
}