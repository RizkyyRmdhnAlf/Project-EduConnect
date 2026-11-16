<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'title',
    'slug',
    'description',
    'owner_id',
    'location',
    'city',
    'address',
    'category',
    'image',
    'cost',
    'is_free',
    'schedule',
    'weekend_availability',
    'facilities',
    'latitude',
    'longitude',
    'verification_status',
])]
class Place extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_free' => 'boolean',
            'weekend_availability' => 'boolean',
            'facilities' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * Get the user who owns/manages the study place.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
