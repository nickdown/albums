<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Aerni\Spotify\Facades\SpotifyFacade as Spotify;
use Illuminate\Http\Request;

class ArtistImportController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return response()->json(['results' => []]);
        }

        try {
            $results = Spotify::searchArtists($query)->limit(5)->get();

            return response()->json([
                'results' => collect($results['artists']['items'])->map(function($artist) {
                    return [
                        'name' => $artist['name'],
                        'spotify_id' => $artist['id'],
                        'spotify_uri' => $artist['uri'],
                        'spotify_image_url' => $artist['images'][0]['url'] ?? null,
                        'already_imported' => Artist::where('spotify_id', $artist['id'])->exists()
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search Spotify'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'spotify_id' => 'required|string',
            'spotify_uri' => 'required|string',
            'spotify_image_url' => 'required|string'
        ]);

        // Find or create the artist
        $artist = Artist::firstOrCreate(
            ['spotify_id' => $request->spotify_id],
            $request->only(['name', 'spotify_uri', 'spotify_image_url'])
        );

        // Attach the artist to the user if not already attached
        if (!auth()->user()->artists()->where('artists.id', $artist->id)->exists()) {
            auth()->user()->artists()->attach($artist->id);
        }

        return redirect()->route('artists.show', $artist)->with('success', 'Artist added to your collection');
    }
}
