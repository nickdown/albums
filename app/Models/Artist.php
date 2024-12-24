<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'spotify_id',
        'spotify_uri',
        'spotify_image_url'
    ];

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    public function recommendations(): MorphMany
    {
        return $this->morphMany(Recommendation::class, 'recommendable');
    }
}
