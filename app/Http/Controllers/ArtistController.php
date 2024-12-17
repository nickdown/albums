<?php

namespace App\Http\Controllers;

use App\Models\Artist;
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
        // Check if user has access to this artist
        if (!auth()->user()->artists()->where('artists.id', $artist->id)->exists()) {
            abort(403);
        }

        $artist->load(['albums' => function ($query) {
            $query->whereIn('id', auth()->user()->albums()->pluck('albums.id'))
                ->orderBy('release_date', 'desc');
        }]);
        
        return Inertia::render('Artists/Show', [
            'artist' => $artist
        ]);
    }

    public function destroy(Artist $artist)
    {
        try {
            // Remove the artist from the user's collection
            auth()->user()->artists()->detach($artist->id);
            
            // Also remove all of the artist's albums from the user's collection
            auth()->user()->albums()->whereIn('albums.id', $artist->albums->pluck('id'))->detach();
            
            return redirect()->route('artists')->with('success', 'Artist has been removed from your collection.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove artist. Please try again.');
        }
    }
}
