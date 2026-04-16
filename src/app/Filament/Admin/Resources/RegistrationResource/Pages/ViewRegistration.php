<?php

namespace App\Filament\Admin\Resources\RegistrationResource\Pages;

use App\Filament\Admin\Resources\RegistrationResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewRegistration extends ViewRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Registration Info')
                    ->schema([
                        TextEntry::make('full_name')->label('Name'),
                        TextEntry::make('email'),
                        TextEntry::make('whatsapp'),
                        TextEntry::make('institution'),
                        TextEntry::make('registration_type')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'national' => 'info',
                                'international' => 'success',
                                default => 'gray',
                            }),
                        TextEntry::make('competitionCategory.name')->label('Category'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'confirmed' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('youtube_url')
                            ->label('YouTube URL')
                            ->url(fn ($record) => $record->youtube_url, true)
                            ->placeholder('—'),
                    ])->columns(3),

                Section::make('Score & Ranking')
                    ->schema([
                        TextEntry::make('final_score')
                            ->label('Final Score')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->color('primary')
                            ->placeholder('Not scored yet'),
                        TextEntry::make('rank')
                            ->label('Rank')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->color('success')
                            ->formatStateUsing(fn ($state) => $state ? "#{$state}" : null)
                            ->placeholder('Not ranked yet'),
                        TextEntry::make('participation_certificate')
                            ->label('Participation Cert')
                            ->formatStateUsing(fn ($state) => $state ? 'Generated' : null)
                            ->badge()
                            ->color('info')
                            ->placeholder('Not generated'),
                        TextEntry::make('winner_certificate')
                            ->label('Winner Cert')
                            ->formatStateUsing(fn ($state) => $state ? 'Generated' : null)
                            ->badge()
                            ->color('success')
                            ->placeholder('Not generated'),
                    ])->columns(4),
            ]);
    }
}
