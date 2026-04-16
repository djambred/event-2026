<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Registration;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class RegistrationChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'Registrations (Last 30 Days)';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(fn ($i) => now()->subDays($i)->format('Y-m-d'));

        $registrations = Registration::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupByRaw('DATE(created_at)')
            ->pluck('count', 'date');

        return [
            'datasets' => [
                [
                    'label' => 'Registrations',
                    'data' => $days->map(fn ($date) => $registrations->get($date, 0))->values()->toArray(),
                    'backgroundColor' => 'rgba(0, 59, 115, 0.1)',
                    'borderColor' => '#003B73',
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
            'labels' => $days->map(fn ($date) => \Carbon\Carbon::parse($date)->format('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
