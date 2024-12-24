<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumPreviewController;
use App\Http\Controllers\ArtistImportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('/preview/albums/{album}', [AlbumPreviewController::class, 'show'])
    ->name('albums.preview');

// User profiles are public
Route::get('/users/{user}', [UserProfileController::class, 'show'])
    ->name('users.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Artist routes
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists');
    Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show');
    Route::delete('/artists/{artist}', [ArtistController::class, 'destroy'])->name('artists.destroy');
    Route::post('/artists/search', [ArtistImportController::class, 'search'])->name('artists.search');
    Route::post('/artists/import', [ArtistImportController::class, 'store'])->name('artists.import');

    // Album routes
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums');
    Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
    Route::post('/albums/search', [AlbumController::class, 'search'])->name('albums.search');
    Route::post('/albums/import', [AlbumController::class, 'import'])->name('albums.import');

    // Recommendation routes
    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations');
    Route::post('/recommendations', [RecommendationController::class, 'store'])->name('recommendations.store');
    Route::delete('/recommendations/{recommendation}', [RecommendationController::class, 'destroy'])->name('recommendations.destroy');
});

require __DIR__.'/auth.php';
