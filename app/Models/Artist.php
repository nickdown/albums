<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
