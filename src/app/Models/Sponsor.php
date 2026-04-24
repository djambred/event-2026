<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'website_url',
        'tier',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function tierOptions(): array
    {
        return [
            'platinum' => 'Platinum',
            'gold' => 'Gold',
            'silver' => 'Silver',
            'bronze' => 'Bronze',
            'media_partner' => 'Media Partner',
        ];
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }
}
