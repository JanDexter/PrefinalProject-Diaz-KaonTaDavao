<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'eatery_id',
        'user_id',
        'rating',
        'body',
    ];

    // the user who wrote the review
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // the eatery that was reviewed
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }
}
