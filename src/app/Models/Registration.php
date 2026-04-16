<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Registration extends Model
{
    protected $fillable = [
        'registration_type',
        'full_name',
        'email',
        'whatsapp',
        'institution',
        'competition_category_id',
        'school_uniform_photo',
        'student_id_document',
        'formal_photo',
        'payment_proof',
        'youtube_url',
        'status',
        'access_token',
        'password',
        'password_changed',
        'final_score',
        'rank',
        'certificate_file',
        'participation_certificate',
        'winner_certificate',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'final_score' => 'decimal:2',
        'rank' => 'integer',
        'password_changed' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Registration $registration) {
            if (empty($registration->access_token)) {
                $registration->access_token = Str::random(32);
            }
            if (empty($registration->password)) {
                $registration->password = Hash::make('ueuevent2026');
            }
        });
    }

    public function competitionCategory(): BelongsTo
    {
        return $this->belongsTo(CompetitionCategory::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function isNational(): bool
    {
        return $this->registration_type === 'national';
    }

    public function isInternational(): bool
    {
        return $this->registration_type === 'international';
    }

    public function calculateFinalScore(): float
    {
        $criterias = $this->competitionCategory->judgingCriterias;
        $totalWeightedScore = 0;

        foreach ($criterias as $criteria) {
            $score = $this->scores()->where('judging_criteria_id', $criteria->id)->first();
            if ($score) {
                $totalWeightedScore += ($score->score * $criteria->weight / 100);
            }
        }

        return round($totalWeightedScore, 2);
    }

    public function getPortalUrl(): string
    {
        return route('participant.portal', $this->access_token);
    }
}
