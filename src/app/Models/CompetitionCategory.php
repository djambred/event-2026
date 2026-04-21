<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompetitionCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'type',
        'price_national',
        'price_international',
        'is_national',
        'is_international',
        'is_active',
    ];

    protected $casts = [
        'price_national' => 'integer',
        'price_international' => 'integer',
        'is_national' => 'boolean',
        'is_international' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function judgingCriterias(): HasMany
    {
        return $this->hasMany(JudgingCriteria::class)->orderBy('sort_order');
    }

    public function certificateTemplates(): HasMany
    {
        return $this->hasMany(CertificateTemplate::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function judges(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'competition_category_judge',
            'competition_category_id',
            'user_id'
        )->withTimestamps();
    }

    public function getActiveCertificateTemplate(?string $type = null): ?CertificateTemplate
    {
        $query = $this->certificateTemplates()->where('is_active', true);

        if ($type) {
            $query->where('type', $type);
        }

        return $query->first();
    }

    public function getFormattedPriceNationalAttribute(): string
    {
        return $this->price_national > 0 ? 'Rp. ' . number_format($this->price_national, 0, ',', '.') : 'Free';
    }

    public function getFormattedPriceInternationalAttribute(): string
    {
        return $this->price_international > 0 ? 'Rp. ' . number_format($this->price_international, 0, ',', '.') : 'Free';
    }
}
