<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $fillable = [
        'registration_id',
        'judging_criteria_id',
        'round',
        'score',
        'notes',
        'scored_by',
    ];

    protected $casts = [
        'score' => 'float',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function judgingCriteria(): BelongsTo
    {
        return $this->belongsTo(JudgingCriteria::class);
    }

    public function scorer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scored_by');
    }
}
