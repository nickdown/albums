<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecommendationController extends Controller
{
    public function index()
    {
        $recommendations = auth()->user()->recommendationsReceived()
            ->with(['recommendable', 'fromUser'])
            ->latest()
            ->get()
            ->map(function ($recommendation) {
                return [
                    'id' => $recommendation->id,
                    'type' => $recommendation->recommendable_type === Artist::class ? 'artist' : 'album',
                    'name' => $recommendation->recommendable->name,
                    'image_url' => $recommendation->recommendable->spotify_image_url,
                    'from_user' => [
                        'id' => $recommendation->fromUser->id,
                        'name' => $recommendation->fromUser->name,
                    ],
                    'note' => $recommendation->note,
                    'created_at' => $recommendation->created_at->diffForHumans(),
                    'url' => $recommendation->recommendable_type === Artist::class 
                        ? route('artists.show', $recommendation->recommendable_id)
                        : route('albums.show', $recommendation->recommendable_id),
                ];
            });

        return Inertia::render('Recommendations/Index', [
            'recommendations' => $recommendations
        ]);
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Recommendation request received:', $request->all());
            
            $validated = $request->validate([
                'to_user_id' => 'required|exists:users,id',
                'recommendable_type' => 'required|in:App\\Models\\Artist,App\\Models\\Album',
                'recommendable_id' => 'required|integer',
                'note' => 'nullable|string|max:500',
            ]);

            \Log::info('Validation passed, creating recommendation');

            // Create recommendation
            $recommendation = Recommendation::create([
                'from_user_id' => auth()->id(),
                'to_user_id' => $validated['to_user_id'],
                'recommendable_type' => $validated['recommendable_type'],
                'recommendable_id' => $validated['recommendable_id'],
                'note' => $validated['note'],
            ]);

            \Log::info('Recommendation created:', $recommendation->toArray());

            return back()->with('success', 'Recommendation sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to create recommendation:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Failed to send recommendation. Please try again.']);
        }
    }

    public function destroy(Recommendation $recommendation)
    {
        // Check if the user is authorized to delete this recommendation
        if ($recommendation->to_user_id !== auth()->id()) {
            abort(403);
        }

        $recommendation->delete();

        return back()->with('success', 'Recommendation removed.');
    }
}
