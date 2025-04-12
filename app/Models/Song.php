<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_id',
        'name',
        'artist',
        'album',
        'duration_ms',
        'release_year',
        'loudness',
        'tempo',
        'danceability',
    ];

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class);
    }
}