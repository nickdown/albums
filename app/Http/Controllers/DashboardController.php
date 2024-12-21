<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Album;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Get recent artist additions from other users
        $recentArtistActivity = Artist::select('artists.*', 'users.id as user_id', 'users.name as user_name', 'artist_user.created_at as added_at')
            ->join('artist_user', 'artists.id', '=', 'artist_user.artist_id')
            ->join('users', 'users.id', '=', 'artist_user.user_id')
            ->where('users.id', '!=', auth()->id())
            ->orderBy('artist_user.created_at', 'desc')
            ->limit(30)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'artist',
                    'name' => $item->name,
                    'image_url' => $item->spotify_image_url,
                    'user_id' => $item->user_id,
                    'user_name' => $item->user_name,
                    'added_at' => Carbon::parse($item->added_at)->toISOString(),
                    'id' => $item->id,
                    'spotify_id' => $item->spotify_id,
                    'spotify_uri' => $item->spotify_uri,
                    'already_added' => auth()->user()->artists()->where('artists.id', $item->id)->exists()
                ];
            });

        // Get recent album additions from other users
        $recentAlbumActivity = Album::select('albums.*', 'artists.name as artist_name', 'users.id as user_id', 'users.name as user_name', 'album_user.created_at as added_at')
            ->join('album_user', 'albums.id', '=', 'album_user.album_id')
            ->join('users', 'users.id', '=', 'album_user.user_id')
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->where('users.id', '!=', auth()->id())
            ->orderBy('album_user.created_at', 'desc')
            ->limit(30)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'album',
                    'name' => $item->name,
                    'artist_name' => $item->artist_name,
                    'image_url' => $item->spotify_image_url,
                    'user_id' => $item->user_id,
                    'user_name' => $item->user_name,
                    'added_at' => Carbon::parse($item->added_at)->toISOString(),
                    'id' => $item->id,
                    'artist_id' => $item->artist_id,
                    'spotify_uri' => $item->spotify_uri,
                    'spotify_id' => $item->spotify_id,
                    'release_date' => $item->release_date,
                    'already_added' => auth()->user()->albums()->where('albums.id', $item->id)->exists()
                ];
            });

        // Combine, sort and limit the activity
        $recentActivity = collect()
            ->concat($recentArtistActivity)
            ->concat($recentAlbumActivity)
            ->sortByDesc('added_at')
            ->values()
            ->take(40);

        return Inertia::render('Dashboard', [
            'recentActivity' => $recentActivity
        ]);
    }
}
