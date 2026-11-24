<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'title',
    'description',
    'reporter_id',
    'reporter_name',
    'learning_location_id',
    'place_slug',
    'moderation_status',
])]
class Flag extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the user who reported the content.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the learning location associated with this report.
     */
    public function learningLocation(): BelongsTo
    {
        return $this->belongsTo(LearningLocation::class, 'learning_location_id');
    }
}
