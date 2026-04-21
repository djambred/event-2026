<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'competition_category_id',
        'type',
        'title',
        'description',
        'zoom_url',
        'is_published',
        'published_at',
        'winners_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'winners_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Announcement $announcement): void {
            if (!$announcement->is_published) {
                return;
            }

            if (!$announcement->published_at) {
                $announcement->published_at = now();
            }

            if ($announcement->type !== 'winner' || !$announcement->competition_category_id) {
                return;
            }

            static::query()
                ->where('competition_category_id', $announcement->competition_category_id)
                ->where('type', 'winner')
                ->where('is_published', true)
                ->when($announcement->exists, fn ($query) => $query->whereKeyNot($announcement->getKey()))
                ->update(['is_published' => false]);
        });
    }

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

    public function scopePublicVisible($query)
    {
        return $query
            ->where('is_published', true)
            ->where(function ($innerQuery) {
                $innerQuery
                    ->where('type', '!=', 'winner')
                    ->orWhereIn('id', static::query()
                        ->selectRaw('MAX(id)')
                        ->where('is_published', true)
                        ->where('type', 'winner')
                        ->groupBy('competition_category_id'));
            });
    }

    public function scopePublicVisibleForCategory($query, int $categoryId)
    {
        return $query
            ->where('competition_category_id', $categoryId)
            ->where('is_published', true)
            ->where(function ($innerQuery) use ($categoryId) {
                $innerQuery
                    ->where('type', '!=', 'winner')
                    ->orWhere('id', static::query()
                        ->where('competition_category_id', $categoryId)
                        ->where('is_published', true)
                        ->where('type', 'winner')
                        ->max('id'));
            });
    }
}
