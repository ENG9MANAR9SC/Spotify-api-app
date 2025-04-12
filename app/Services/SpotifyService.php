<?php

namespace App\Services;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Client\Factory as Http;
use Illuminate\Support\Facades\Request;

class SpotifyService
{

    protected $httpClient;
    protected $clientId;
    protected $clientSecret;
    protected $accessTokenCacheKey = 'spotify_access_token';
    protected $tokenExpirationKey  = 'spotify_token_expires_at';

    public function __construct(Http $httpClient)
    {
        $this->httpClient   = $httpClient;
        $this->clientId     = env('SPOTIFY_CLIENT_ID');
        $this->clientSecret = env('SPOTIFY_CLIENT_SECRET');
    }

    protected function getAccessToken(): ?string
    {
        if (Cache::has($this->accessTokenCacheKey) && Cache::get($this->tokenExpirationKey) > now()->timestamp) {
            return Cache::get($this->accessTokenCacheKey);
        }

        $credentials = base64_encode($this->clientId . ':' . $this->clientSecret);
        Log::info($credentials);
        $response = $this->httpClient->withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
        ]);
        Log::info('Response Status Code: ' . $response->status());
        Log::info('Response Headers: ' . json_encode($response->headers()));
        Log::info('Response Body: ' . $response->body());

       
        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
            $expiresIn = $data['expires_in'];
            Cache::put($this->accessTokenCacheKey, $accessToken, now()->addSeconds($expiresIn - 60));
            Cache::put($this->tokenExpirationKey, now()->addSeconds($expiresIn - 60)->timestamp, now()->addSeconds($expiresIn - 60));
            return $accessToken;
        }

        Log::error('Failed to get Spotify access token:', (array) $response->json());
        return null;
    }

    protected function makeRequest(string $method, string $uri, array $data = [])
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        return $this->httpClient->withToken($accessToken)->$method('https://api.spotify.com/v1/' . $uri, $data);
    }

    public function searchPlaylists(string $query)
    {
        
        $response = $this->makeRequest('get', 'search', [
            'q' => $query,
            'type' => 'playlist',
        ]);

        return $response ? $response->json()['playlists']['items'] ?? [] : [];
    }

    public function getPlaylistById(string $playlistId)
    {
        $response = $this->makeRequest('get', 'playlists/' . $playlistId);
        return $response ? $response->json() : null;
    }

    public function getPlaylistTracks(string $playlistId, array $options = [])
    {
        $response = $this->makeRequest('get', 'playlists/' . $playlistId . '/tracks', $options);
        return $response ? $response->json()['items'] ?? [] : [];
    }
    public function searchTracks(string $query, array $options = [])
    {
        $response = $this->makeRequest('get', 'search', array_merge(['q' => $query, 'type' => 'track'], $options));
        return $response ? $response->json()['tracks']['items'] ?? [] : [];
    }
    
    public function getTrack(string $trackId)
    {
        $response = $this->makeRequest('get', 'tracks/' . $trackId);
        return $response ? $response->json() : null;
    }

    public function getTracks(array $trackIds)
    {
        if (empty($trackIds)) {
            return [];
        }
        $response = $this->makeRequest('get', 'tracks', ['ids' => implode(',', $trackIds)]);
        return $response ? $response->json()['tracks'] ?? [] : [];
    }

    public function getTrackAudioFeatures(string $trackId)
    {
        $response = $this->makeRequest('get', 'audio-features/' . $trackId);
        return $response ? $response->json() : null;
    }


}