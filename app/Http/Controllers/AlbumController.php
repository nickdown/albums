<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')->orderBy('name')->get();
        return Inertia::render('Albums/Index', [
            'albums' => $albums
        ]);
    }

    public function show(Album $album)
    {
        $album->load('artist');
        return Inertia::render('Albums/Show', [
            'album' => $album
        ]);
    }

    public function resync(Album $album)
    {
        try {
            // Note: In a production app, you would want to:
            // 1. Use a proper Spotify API client
            // 2. Handle authentication properly
            // 3. Store API credentials in .env
            // 4. Use a job queue for this operation
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.spotify.token')
            ])->get("https://api.spotify.com/v1/albums/{$album->spotify_id}");

            if ($response->successful()) {
                $spotifyAlbum = $response->json();
                
                $album->update([
                    'spotify_image_url' => $spotifyAlbum['images'][0]['url'] ?? $album->spotify_image_url,
                    'spotify_uri' => $spotifyAlbum['uri'] ?? $album->spotify_uri,
                ]);

                return back()->with('success', 'Album data has been updated from Spotify.');
            }

            return back()->with('error', 'Could not fetch album data from Spotify.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while syncing with Spotify.');
        }
    }
} 