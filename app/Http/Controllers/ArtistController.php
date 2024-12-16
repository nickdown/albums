<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Inertia\Inertia;

class ArtistController extends Controller
{
    public function index()
    {
        return Inertia::render('Artists/Index', [
            'artists' => Artist::orderBy('name')->get()
        ]);
    }
}
