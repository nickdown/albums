<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Inertia\Inertia;

class AlbumPreviewController extends Controller
{
    public function show(Album $album)
    {
        // Redirect authenticated users to the main album show page
        if (auth()->check()) {
            return redirect()->route('albums.show', $album);
        }

        $album->load(['artist', 'users' => function($query) {
            $query->select('users.id', 'name');
        }]);

        return Inertia::render('Albums/GuestShow', [
            'album' => $album,
            'canLogin' => \Route::has('login'),
            'canRegister' => \Route::has('register'),
        ]);
    }
}
