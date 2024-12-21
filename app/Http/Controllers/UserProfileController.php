<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $artists = $user->artists()
            ->withCount(['albums' => function($query) use ($user) {
                $query->whereHas('users', function($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
            }])
            ->orderBy('name')
            ->get();

        $albums = $user->albums()
            ->with('artist')
            ->orderBy('name')
            ->get();

        return Inertia::render('Users/Show', [
            'profile' => [
                'id' => $user->id,
                'name' => $user->name,
                'artists' => $artists,
                'albums' => $albums,
                'artists_count' => $artists->count(),
                'albums_count' => $albums->count(),
                'joined' => $user->created_at->format('F Y')
            ]
        ]);
    }
} 