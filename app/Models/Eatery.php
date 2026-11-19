<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Eatery extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'name',
        'slug',
        'address',
        'price_range',
        'specialty',
        'is_open',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    // an eatery belongs to one district
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    // many-to-many with features through the eatery_feature pivot table
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }

    // each eatery has only one business permit
    public function permit(): HasOne
    {
        return $this->hasOne(Permit::class);
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }
}
