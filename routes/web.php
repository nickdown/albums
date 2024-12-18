<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumPreviewController;
use App\Http\Controllers\ArtistImportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('/preview/albums/{album}', [AlbumPreviewController::class, 'show'])
    ->name('albums.preview');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])
        ->middleware(['auth', 'verified'])->name('albums.destroy');
    Route::post('/albums/search', [AlbumController::class, 'search'])
        ->middleware(['auth', 'verified'])->name('albums.search');
    Route::post('/albums/import', [AlbumController::class, 'import'])
        ->middleware(['auth', 'verified'])->name('albums.import');
});

require __DIR__.'/auth.php';
