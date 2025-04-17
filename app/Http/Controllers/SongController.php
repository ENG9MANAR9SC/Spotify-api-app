<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class SongController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    //search songs in spotify
    public function searchSongs(Request $request)
    {
        $query = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
    
        if (!$query) {
            return response()->json(['error' => 'Please provide a search query.'], 400);
        }
    
        try {
            $searchResults = $this->spotifyService->searchTracks($query, ['limit' => $perPage, 'offset' => $offset]);
            $trackItems = $searchResults['items'] ?? [];
    
            if (!empty($trackItems)) {
                $trackIds = array_column($trackItems, 'id');
                $fullTracks = $this->spotifyService->getTracks($trackIds);
                Log::info('$fullTracks');
                Log::info($fullTracks);
                // Create a mapping of track ID to the full track data (including preview_url)
                $fullTrackMap = collect($fullTracks)->keyBy('id');
    
                // Merge the preview_url into the search results
                $enhancedTracks = collect($trackItems)->map(function ($searchResultTrack) use ($fullTrackMap) {
                    $fullTrackData = $fullTrackMap->get($searchResultTrack['id']);
                    if ($fullTrackData && isset($fullTrackData['preview_url'])) {
                        $searchResultTrack['preview_url'] = $fullTrackData['preview_url'];
                    } else {
                        $searchResultTrack['preview_url'] = null; // Or some other default value
                    }
                    return $searchResultTrack;
                })->toArray();
    
                $total = $searchResults['total'] ?? count($trackItems);
                $data = [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'data' => $enhancedTracks,
                ];
                return response()->json($data);
    
            } else {
                return response()->json([
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => 0,
                    'data' => [],
                ]);
            }
    
        } catch (\Exception $e) {
            Log::error('Error searching and fetching full Spotify tracks: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search for songs.'], 500);
        }
    }

    public function getTrendTracks() 
    
    {  
        // samples songs
        $trendsTracks = ['7ouMYWpwJ422jRcDASZB7P', '4VqPOruhp5EdPBeR92t6lQ', '2takcwOaAZWiXQijPHIx7B'];

        $results = $this->spotifyService->getTracks($trendsTracks);

        return response()->json($results);

    }


}