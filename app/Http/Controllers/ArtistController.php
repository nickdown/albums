<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::withCount('albums')->orderBy('name')->get();
        return Inertia::render('Artists/Index', [
            'artists' => $artists
        ]);
    }

    public function show(Artist $artist)
    {
        $artist->load(['albums' => function ($query) {
            $query->orderBy('release_date', 'desc');
        }]);
        
        return Inertia::render('Artists/Show', [
            'artist' => $artist
        ]);
    }

    public function destroy(Artist $artist)
    {
        try {
            $artist->albums()->delete();
            $artist->delete();
            
            return redirect()->route('artists')->with('success', 'Artist and their albums have been deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete artist. Please try again.');
        }
    }
}
