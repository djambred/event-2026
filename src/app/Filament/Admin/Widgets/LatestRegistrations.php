<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Registration;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRegistrations extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 2;

    protected static ?string $heading = 'Latest Registrations';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Registration::query()
                    ->with('competitionCategory')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->size('sm')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('registration_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'national' => 'info',
                        'international' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('competitionCategory.name')
                    ->label('Category'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->since()
                    ->sortable(),
            ])
            ->paginated(false)
            ->defaultSort('created_at', 'desc');
    }
}
