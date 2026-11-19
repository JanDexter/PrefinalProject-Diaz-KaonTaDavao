<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class District extends Model
{
    protected $fillable = [
        'name',
    ];

    // a district has many eateries
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class);
    }

    // reviews of all the eateries in this district (district -> eateries -> reviews)
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Eatery::class);
    }
}
