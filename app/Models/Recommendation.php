<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'note',
        'recommendable_type',
        'recommendable_id'
    ];

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function recommendable(): MorphTo
    {
        return $this->morphTo();
    }
}
