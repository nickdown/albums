<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Aerni\Spotify\Facades\SpotifyFacade as Spotify;
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

    public function search(Request $request)
    {
        $artistId = $request->input('artist_id');

        try {
            // First get the artist's Spotify ID
            $artist = \App\Models\Artist::findOrFail($artistId);

            // Then get all their albums from Spotify
            $results = Spotify::artistAlbums($artist->spotify_id)
                ->includeGroups('album')
                ->limit(50)
                ->get();

            return response()->json([
                'results' => collect($results['items'])->map(function($album) use ($artistId) {
                    return [
                        'name' => $album['name'],
                        'spotify_id' => $album['id'],
                        'spotify_uri' => $album['uri'],
                        'spotify_image_url' => $album['images'][0]['url'] ?? null,
                        'release_date' => $album['release_date'],
                        'already_imported' => Album::where('spotify_id', $album['id'])
                            ->where('artist_id', $artistId)
                            ->exists()
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch albums from Spotify'], 500);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'albums' => 'required|array',
            'albums.*.name' => 'required|string',
            'albums.*.artist_id' => 'required|exists:artists,id',
            'albums.*.spotify_id' => 'required|string|unique:albums,spotify_id',
            'albums.*.spotify_uri' => 'required|string',
            'albums.*.spotify_image_url' => 'required|string',
            'albums.*.release_date' => 'required|date'
        ]);

        foreach ($request->albums as $albumData) {
            Album::create($albumData);
        }

        return redirect()->back()->with('success', count($request->albums) . ' albums imported successfully');
    }
}
