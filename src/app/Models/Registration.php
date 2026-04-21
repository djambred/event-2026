<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'stage',
        'access_token',
        'password',
        'password_changed',
        'final_score',
        'rank',
        'grandfinal_score',
        'grandfinal_rank',
        'certificate_file',
        'participation_certificate',

    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'final_score' => 'float',
        'grandfinal_score' => 'float',
        'rank' => 'integer',
        'grandfinal_rank' => 'integer',
        'password_changed' => 'boolean',
    ];

    /**
     * Normalize WhatsApp number: strip spaces/dashes, convert 08xx to +628xx.
     */
    public function setWhatsappAttribute($value): void
    {
        $number = preg_replace('/[\s\-\(\)]+/', '', trim($value));

        if (str_starts_with($number, '08')) {
            $number = '+62' . substr($number, 1);
        } elseif (str_starts_with($number, '62') && !str_starts_with($number, '+')) {
            $number = '+' . $number;
        } elseif (str_starts_with($number, '8') && strlen($number) >= 10 && strlen($number) <= 13) {
            $number = '+62' . $number;
        }

        $this->attributes['whatsapp'] = $number;
    }

    /**
     * Generate a random register key in the format REG-XXXXXXXX.
     */
    public static function generateRegisterKey(): string
    {
        return 'REG-' . strtoupper(Str::random(8));
    }

    protected static function booted(): void
    {
        static::creating(function (Registration $registration) {
            if (empty($registration->access_token)) {
                $registration->access_token = Str::random(32);
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

    /**
     * Calculate final score. Score range: 0-10, Weight: percentage (sums to 100).
     * Formula: sum(avg(score) × weight / 100) for each criteria.
     */
    public function calculateFinalScore(string $round = 'selection'): float
    {
        $criterias = $this->competitionCategory->judgingCriterias;
        $totalWeightedScore = 0;

        foreach ($criterias as $criteria) {
            $averageScore = $this->scores()
                ->where('judging_criteria_id', $criteria->id)
                ->where('round', $round)
                ->avg('score');

            if ($averageScore !== null) {
                $totalWeightedScore += ($averageScore * $criteria->weight / 100);
            }
        }

        return round($totalWeightedScore, 2);
    }

    public function calculateGrandfinalScore(): float
    {
        return $this->calculateFinalScore('grandfinal');
    }

    public function getPortalUrl(): string
    {
        return route('participant.portal', $this->access_token);
    }
}
