<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'owner_id',
    'name',
    'title',
    'slug',
    'category',
    'description',
    'location',
    'city',
    'public_address',
    'address',
    'latitude',
    'longitude',
    'cost_info',
    'cost',
    'is_free',
    'schedule',
    'weekend_availability',
    'facilities',
    'image',
    'publication_status',
    'verification_status',
])]
class LearningLocation extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     */
    protected $table = 'learning_locations';

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
     * Alias `title` to ERD column `name`.
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): ?string => $attributes['name'] ?? null,
            set: fn (?string $value): array => ['name' => $value],
        );
    }

    /**
     * Alias `address` to ERD column `public_address`.
     */
    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): ?string => $attributes['public_address'] ?? null,
            set: fn (?string $value): array => ['public_address' => $value],
        );
    }

    /**
     * Alias `cost` to ERD column `cost_info`.
     */
    protected function cost(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): ?string => $attributes['cost_info'] ?? null,
            set: fn (?string $value): array => ['cost_info' => $value],
        );
    }

    /**
     * Alias `verification_status` to ERD column `publication_status`.
     */
    protected function verificationStatus(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): ?string => $attributes['publication_status'] ?? null,
            set: fn (?string $value): array => ['publication_status' => $value],
        );
    }

    /**
     * Get the user who owns/manages the study location (`owns` in ERD).
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
