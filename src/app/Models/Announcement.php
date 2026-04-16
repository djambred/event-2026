<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'competition_category_id',
        'title',
        'description',
        'is_published',
        'published_at',
        'winners_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'winners_count' => 'integer',
    ];

    public function competitionCategory(): BelongsTo
    {
        return $this->belongsTo(CompetitionCategory::class);
    }

    public function getWinners()
    {
        return Registration::where('competition_category_id', $this->competition_category_id)
            ->where('status', 'confirmed')
            ->whereNotNull('final_score')
            ->whereNotNull('rank')
            ->orderBy('rank')
            ->limit($this->winners_count)
            ->get();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
