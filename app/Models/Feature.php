<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    protected $fillable = [
        'name',
    ];

    // a feature can be on many eateries
    public function eateries(): BelongsToMany
    {
        return $this->belongsToMany(Eatery::class);
    }
}
