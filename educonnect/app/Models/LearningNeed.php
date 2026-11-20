<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'reporter_id',
    'title',
    'category',
    'description',
    'area_label',
    'need_status',
])]
class LearningNeed extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the user who reported this learning need (`reports` in ERD).
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the assistance offers received for this need (`receives` in ERD).
     */
    public function assistanceOffers(): HasMany
    {
        return $this->hasMany(AssistanceOffer::class, 'need_id');
    }
}
