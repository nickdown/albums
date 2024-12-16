<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')->orderBy('name')->get();
        return Inertia::render('Albums/Index', [
            'albums' => $albums
        ]);
    }
} 