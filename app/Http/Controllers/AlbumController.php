<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Aerni\Spotify\Facades\SpotifyFacade as Spotify;
use Inertia\Inertia;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = auth()->user()->albums()->with('artist')->orderBy('name')->get();
        return Inertia::render('Albums/Index', [
            'albums' => $albums
        ]);
    }

    public function show(Album $album)
    {
        // Check if user has access to this album
        if (!auth()->user()->albums()->where('albums.id', $album->id)->exists()) {
            abort(403);
        }

        $album->load('artist');
        return Inertia::render('Albums/Show', [
            'album' => $album
        ]);
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
                            ->whereHas('users', function($query) {
                                $query->where('users.id', auth()->id());
                            })
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
            'albums.*.spotify_id' => 'required|string',
            'albums.*.spotify_uri' => 'required|string',
            'albums.*.spotify_image_url' => 'required|string',
            'albums.*.release_date' => 'required|date'
        ]);

        foreach ($request->albums as $albumData) {
            // Find or create the album
            $album = Album::firstOrCreate(
                ['spotify_id' => $albumData['spotify_id']],
                [
                    'name' => $albumData['name'],
                    'artist_id' => $albumData['artist_id'],
                    'spotify_uri' => $albumData['spotify_uri'],
                    'spotify_image_url' => $albumData['spotify_image_url'],
                    'release_date' => $albumData['release_date']
                ]
            );

            // Attach the album to the user if not already attached
            if (!auth()->user()->albums()->where('albums.id', $album->id)->exists()) {
                auth()->user()->albums()->attach($album->id);
            }
        }

        return redirect()->back()->with('success', count($request->albums) . ' albums added to your collection');
    }
}
