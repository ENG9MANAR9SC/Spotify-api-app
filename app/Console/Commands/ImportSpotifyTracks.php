<?php

namespace App\Console\Commands;

use App\Models\Song;
use Illuminate\Console\Command;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Log;


class ImportSpotifyTracks extends Command
{
    protected $signature   = 'spotify:import-tracks';
    protected $description = 'Imports a list of tracks from Spotify into the database.';

    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        parent::__construct();
        $this->spotifyService = $spotifyService;
    }

    public function handle()
    {
        $trackIds = [
            // Add a list of Spotify Track IDs 
            '7ouMYWpwJ422jRcDASZB7P',
            '4VqPOruhp5EdPBeR92t6lQ',
            '2takcwOaAZWiXQijPHIx7B'
            
        ];

        $this->info('Fetching track details from Spotify...');
        $tracks = $this->spotifyService->getTracks($trackIds);

        if (!empty($tracks)) {
            $this->info('Storing tracks in the database...');
            foreach ($tracks as $spotifyTrack) {
                
                Song::firstOrCreate([
                    'spotify_id' => $spotifyTrack['id'],
                ], [
                    'name'          => $spotifyTrack['name'],
                    'artist'        => implode(', ', array_column($spotifyTrack['artists'], 'name')),
                    'album'         => $spotifyTrack['album']['name'] ?? null,
                    'duration_ms'   => $spotifyTrack['duration_ms'] ?? null,
                    'release_year'  => substr($spotifyTrack['album']['release_date'] ?? '', 0, 4),

                ]);
            }
            $this->info('Tracks imported successfully!');
        } else {
            $this->error('Failed to fetch tracks from Spotify.');
        }
    }
}