<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name',
        'type',
        'competition_category_id',
        'background_image',
        'name_x',
        'name_y',
        'name_font_size',
        'name_color',
        'category_x',
        'category_y',
        'category_font_size',
        'category_color',
        'rank_x',
        'rank_y',
        'rank_font_size',
        'rank_color',
        'is_active',
    ];

    protected $casts = [
        'name_x' => 'integer',
        'name_y' => 'integer',
        'name_font_size' => 'integer',
        'category_x' => 'integer',
        'category_y' => 'integer',
        'category_font_size' => 'integer',
        'rank_x' => 'integer',
        'rank_y' => 'integer',
        'rank_font_size' => 'integer',
        'is_active' => 'boolean',
    ];

    public function competitionCategory(): BelongsTo
    {
        return $this->belongsTo(CompetitionCategory::class);
    }
}
