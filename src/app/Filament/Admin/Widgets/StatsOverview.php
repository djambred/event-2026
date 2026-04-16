<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Registration;
use App\Models\CompetitionCategory;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $total = Registration::count();
        $pending = Registration::where('status', 'pending')->count();
        $confirmed = Registration::where('status', 'confirmed')->count();
        $rejected = Registration::where('status', 'rejected')->count();
        $national = Registration::where('registration_type', 'national')->count();
        $international = Registration::where('registration_type', 'international')->count();
        $scored = Registration::whereNotNull('final_score')->count();
        $categories = CompetitionCategory::where('is_active', true)->count();

        return [
            Stat::make('Total Registrations', $total)
                ->description($national . ' national, ' . $international . ' international')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart($this->getRegistrationTrend()),

            Stat::make('Pending Verification', $pending)
                ->description($pending > 0 ? 'Requires attention' : 'All clear')
                ->descriptionIcon($pending > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($pending > 0 ? 'warning' : 'success'),

            Stat::make('Confirmed', $confirmed)
                ->description(($total > 0 ? round($confirmed / $total * 100) : 0) . '% of total')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Rejected', $rejected)
                ->description(($total > 0 ? round($rejected / $total * 100) : 0) . '% of total')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Scored Participants', $scored)
                ->description($scored . ' of ' . $confirmed . ' confirmed')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Active Categories', $categories)
                ->description('Competition categories')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('gray'),
        ];
    }

    private function getRegistrationTrend(): array
    {
        return Registration::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->pluck('count')
            ->toArray() ?: [0];
    }
}
