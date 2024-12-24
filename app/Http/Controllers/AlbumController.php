<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Aerni\Spotify\Facades\SpotifyFacade as Spotify;
use Inertia\Inertia;
use App\Models\User;

class AlbumController extends Controller
{
    public function index()
    {
        $myAlbums = auth()->user()->albums()
            ->with('artist')
            ->orderBy('name')
            ->get();

        $otherAlbums = Album::whereDoesntHave('users', function($query) {
                $query->where('users.id', auth()->id());
            })
            ->whereHas('users')
            ->with(['artist', 'users' => function($query) {
                $query->select('users.id', 'users.name');
            }])
            ->inRandomOrder()
            ->limit(20)
            ->get();

        return Inertia::render('Albums/Index', [
            'myAlbums' => $myAlbums,
            'otherAlbums' => $otherAlbums
        ]);
    }

    public function show(Album $album)
    {
        $album->load(['artist', 'users' => function($query) {
            $query->select('users.id', 'name');
        }]);

        if (auth()->check()) {
            // Check if user has access to this album
            $inCollection = auth()->user()->albums()->where('albums.id', $album->id)->exists();
            
            // Get all users except the current user for recommendations
            $users = User::where('id', '!=', auth()->id())
                ->orderBy('name')
                ->get(['id', 'name']);

            return Inertia::render('Albums/Show', [
                'album' => array_merge($album->toArray(), [
                    'in_collection' => $inCollection
                ]),
                'users' => $users
            ]);
        }

        return Inertia::render('Albums/GuestShow', [
            'album' => $album,
            'canLogin' => \Route::has('login'),
            'canRegister' => \Route::has('register'),
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

    protected function formatReleaseDate($date, $precision)
    {
        return match ($precision) {
            'year' => $date . '-01-01',
            'month' => $date . '-01',
            default => $date,
        };
    }

    public function import(Request $request)
    {
        $request->validate([
            'albums' => 'required|array',
            'albums.*.spotify_id' => 'required|string',
            'albums.*.artist_id' => 'required|exists:artists,id'
        ]);

        try {
            foreach ($request->albums as $albumData) {
                // First, ensure the artist is in the user's collection
                $artist = \App\Models\Artist::findOrFail($albumData['artist_id']);
                if (!auth()->user()->artists()->where('artists.id', $artist->id)->exists()) {
                    auth()->user()->artists()->attach($artist->id);
                }

                // Fetch fresh album data from Spotify
                $spotifyAlbum = Spotify::album($albumData['spotify_id'])->get();

                // Create album data array from Spotify response
                $freshAlbumData = [
                    'name' => $spotifyAlbum['name'],
                    'artist_id' => $albumData['artist_id'],
                    'spotify_id' => $spotifyAlbum['id'],
                    'spotify_uri' => $spotifyAlbum['uri'],
                    'spotify_image_url' => $spotifyAlbum['images'][0]['url'] ?? null,
                    'release_date' => $this->formatReleaseDate(
                        $spotifyAlbum['release_date'],
                        $spotifyAlbum['release_date_precision']
                    )
                ];

                // Find or create the album with fresh data
                $album = Album::firstOrCreate(
                    ['spotify_id' => $freshAlbumData['spotify_id']],
                    $freshAlbumData
                );

                // Attach the album to the user if not already attached
                if (!auth()->user()->albums()->where('albums.id', $album->id)->exists()) {
                    auth()->user()->albums()->attach($album->id);
                }
            }

            return redirect()->back()->with('success', count($request->albums) . ' albums added to your collection');
        } catch (\Exception $e) {
            logger()->error('Failed to import album', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to fetch album details from Spotify. Please try again.');
        }
    }

    public function destroy(Album $album)
    {
        $user = auth()->user();
        $user->albums()->detach($album->id);

        return redirect()->route('albums')->with('success', 'Album removed from your collection');
    }
}
