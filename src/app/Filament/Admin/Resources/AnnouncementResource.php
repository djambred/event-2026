<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Announcement Details')
                    ->schema([
                        Forms\Components\Select::make('competition_category_id')
                            ->relationship('competitionCategory', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),

                        Forms\Components\Select::make('type')
                            ->options([
                                'info' => 'Info / Pengumuman',
                                'zoom' => 'Link Zoom Meeting',
                                'winner' => 'Winner Announcement',
                            ])
                            ->default('info')
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder(fn (Forms\Get $get) => match ($get('type')) {
                                'zoom' => 'e.g. Zoom Seleksi - English Storytelling',
                                'winner' => 'e.g. Winner Announcement - English Storytelling',
                                default => 'e.g. Jadwal Seleksi Tahap 1',
                            }),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->placeholder('Deskripsi pengumuman...'),

                        Forms\Components\TextInput::make('zoom_url')
                            ->label('Zoom Meeting URL')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://zoom.us/j/...')
                            ->columnSpanFull()
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'zoom')
                            ->required(fn (Forms\Get $get): bool => $get('type') === 'zoom'),

                        Forms\Components\TextInput::make('winners_count')
                            ->label('Number of Winners to Display')
                            ->numeric()
                            ->default(3)
                            ->minValue(1)
                            ->maxValue(10)
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'winner'),
                    ])->columns(2),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('When published, winners will be visible on the public announcements page.')
                            ->live(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->visible(fn (Forms\Get $get): bool => $get('is_published'))
                            ->default(now()),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('competitionCategory.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'zoom' => 'info',
                        'winner' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'zoom' => 'Zoom',
                        'winner' => 'Winner',
                        default => 'Info',
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('winners_count')
                    ->label('Winners')
                    ->alignCenter()
                    ->placeholder('-'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Not published'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('competition_category_id')
                    ->relationship('competitionCategory', 'name')
                    ->label('Category'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-globe-alt')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalDescription('This will publish the announcement. For winner type, any other published winner announcement in the same category will be automatically unpublished.')
                    ->visible(fn (Announcement $record): bool => !$record->is_published)
                    ->action(function (Announcement $record) {
                        if ($record->type === 'winner') {
                            $winners = $record->getWinners();
                            if ($winners->isEmpty()) {
                                Notification::make()
                                    ->title('Cannot publish: no scored and ranked participants found in this category.')
                                    ->danger()
                                    ->send();

                                return;
                            }
                        }

                        $record->update([
                            'is_published' => true,
                            'published_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Announcement published!')
                            ->body($record->competitionCategory->name)
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('unpublish')
                    ->icon('heroicon-o-eye-slash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Announcement $record): bool => $record->is_published)
                    ->action(function (Announcement $record) {
                        $record->update([
                            'is_published' => false,
                        ]);
                        Notification::make()
                            ->title('Announcement unpublished')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('previewWinners')
                    ->label('Preview Winners')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalContent(function (Announcement $record) {
                        $winners = $record->getWinners();
                        return view('filament.winners-preview', [
                            'announcement' => $record,
                            'winners' => $winners,
                        ]);
                    })
                    ->modalHeading('Winner Preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
