<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Registration;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class CategoryDistributionChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'Registrations by Category';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Registration::query()
            ->join('competition_categories', 'registrations.competition_category_id', '=', 'competition_categories.id')
            ->selectRaw('competition_categories.name, COUNT(*) as count')
            ->groupBy('competition_categories.name')
            ->orderByDesc('count')
            ->pluck('count', 'name');

        $colors = ['#003B73', '#0D5DA6', '#E8A317', '#8B6914', '#2563eb', '#059669', '#dc2626', '#7c3aed'];

        return [
            'datasets' => [
                [
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $data->count()),
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
