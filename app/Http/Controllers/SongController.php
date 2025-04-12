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

        $results = $this->spotifyService->searchTracks($query);

        return response()->json($results);
    }
}