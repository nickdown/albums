<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtistController extends Controller
{
    public function index()
    {
        $myArtists = auth()->user()->artists()
            ->withCount(['albums' => function($query) {
                $query->whereHas('users', function($q) {
                    $q->where('users.id', auth()->id());
                });
            }])
            ->orderBy('name')
            ->get();

        $otherArtists = Artist::whereDoesntHave('users', function($query) {
                $query->where('users.id', auth()->id());
            })
            ->whereHas('users')
            ->with(['users' => function($query) {
                $query->select('users.id', 'users.name');
            }])
            ->inRandomOrder()
            ->limit(20)
            ->get();

        return Inertia::render('Artists/Index', [
            'myArtists' => $myArtists,
            'otherArtists' => $otherArtists
        ]);
    }

    public function show(Artist $artist)
    {
        // Check if the artist is in the user's collection
        $inCollection = auth()->user()->artists()->where('artists.id', $artist->id)->exists();

        // Get the user's albums for this artist if they have added it to their collection
        $myAlbums = $inCollection ? 
            $artist->albums()
                ->whereIn('id', auth()->user()->albums()->pluck('albums.id'))
                ->orderBy('release_date', 'desc')
                ->get() : 
            collect();

        // Get other users' albums for this artist
        $otherAlbums = $artist->albums()
            ->whereNotIn('id', auth()->user()->albums()->pluck('albums.id'))
            ->whereHas('users')
            ->with(['users' => function($query) {
                $query->select('users.id', 'users.name');
            }])
            ->orderBy('release_date', 'desc')
            ->get();

        // Get all users except the current user for recommendations
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get(['id', 'name']);
        
        return Inertia::render('Artists/Show', [
            'artist' => array_merge($artist->toArray(), [
                'my_albums' => $myAlbums,
                'other_albums' => $otherAlbums,
                'in_collection' => $inCollection
            ]),
            'users' => $users
        ]);
    }

    public function destroy(Artist $artist)
    {
        try {
            // Get the user's albums that are by this artist
            $albumsToRemove = $artist->albums()
                ->whereHas('users', function($query) {
                    $query->where('users.id', auth()->id());
                })
                ->pluck('id');

            // Remove the artist from the user's collection
            auth()->user()->artists()->detach($artist->id);
            
            // Remove only this artist's albums from the user's collection
            auth()->user()->albums()->detach($albumsToRemove);
            
            return redirect()->route('artists')->with('success', 'Artist has been removed from your collection.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove artist. Please try again.');
        }
    }
}
