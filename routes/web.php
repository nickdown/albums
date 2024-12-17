<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistImportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/artists', [ArtistController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('artists');
    Route::get('/artists/{artist}', [ArtistController::class, 'show'])
        ->middleware(['auth', 'verified'])->name('artists.show');
    Route::delete('/artists/{artist}', [ArtistController::class, 'destroy'])
        ->middleware(['auth', 'verified'])->name('artists.destroy');
    Route::post('/artists/search', [ArtistImportController::class, 'search'])
        ->middleware(['auth', 'verified'])->name('artists.search');
    Route::post('/artists/import', [ArtistImportController::class, 'store'])
        ->middleware(['auth', 'verified'])->name('artists.import');

    Route::get('/albums', [AlbumController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('albums');
    Route::get('/albums/{album}', [AlbumController::class, 'show'])
        ->middleware(['auth', 'verified'])->name('albums.show');
    Route::post('/albums/{album}/resync', [AlbumController::class, 'resync'])
        ->middleware(['auth', 'verified'])->name('albums.resync');
});

require __DIR__.'/auth.php';
