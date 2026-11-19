<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'need_id',
    'volunteer_id',
    'offer_description',
    'offer_status',
])]
class AssistanceOffer extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the learning need associated with this offer.
     */
    public function need(): BelongsTo
    {
        return $this->belongsTo(LearningNeed::class, 'need_id');
    }

    /**
     * Get the volunteer who submitted this offer (`submits` in ERD).
     */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }
}
