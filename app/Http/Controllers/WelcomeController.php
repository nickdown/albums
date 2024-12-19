<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        $recentAlbums = Album::with(['artist', 'users' => function ($query) {
                $query->select('users.id', 'name');
            }])
            ->select('id', 'name', 'spotify_image_url', 'artist_id', 'release_date')
            ->whereHas('users')
            ->orderBy('created_at', 'desc')
            ->take(40)
            ->get()
            ->map(function ($album) {
                return [
                    'id' => $album->id,
                    'name' => $album->name,
                    'artist_name' => $album->artist->name,
                    'image_url' => $album->spotify_image_url,
                    'release_date' => $album->release_date,
                    'added_by' => $album->users->first()->name
                ];
            });

        return Inertia::render('Welcome', [
            'recentAlbums' => $recentAlbums,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
