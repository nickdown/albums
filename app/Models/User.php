<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function artists()
    {
        return $this->belongsToMany(Artist::class)
            ->withTimestamps()
            ->orderBy('name');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class)
            ->withTimestamps()
            ->orderBy('name');
    }

    public function recommendationsSent(): HasMany
    {
        return $this->hasMany(Recommendation::class, 'from_user_id');
    }

    public function recommendationsReceived(): HasMany
    {
        return $this->hasMany(Recommendation::class, 'to_user_id');
    }
}
