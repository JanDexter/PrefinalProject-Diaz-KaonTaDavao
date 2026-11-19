<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
