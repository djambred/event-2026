<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JudgingCriteria extends Model
{
    protected $table = 'judging_criterias';

    protected $fillable = [
        'competition_category_id',
        'name',
        'description',
        'weight',
        'sort_order',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function competitionCategory(): BelongsTo
    {
        return $this->belongsTo(CompetitionCategory::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
