<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SponsorResource\Pages;
use App\Models\Sponsor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SponsorResource extends Resource
{
    protected static ?string $model = Sponsor::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Sponsors';

    protected static ?string $modelLabel = 'Sponsor';

    protected static ?string $pluralModelLabel = 'Sponsors';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sponsor Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Sponsor Name'),

                        Forms\Components\Select::make('tier')
                            ->options(Sponsor::tierOptions())
                            ->required()
                            ->default('bronze')
                            ->label('Tier'),

                        Forms\Components\TextInput::make('website_url')
                            ->url()
                            ->maxLength(500)
                            ->label('Website URL')
                            ->placeholder('https://example.com'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order'),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Active'),

                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->directory('sponsors')
                            ->imagePreviewHeight('150')
                            ->label('Logo')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->height(40)
                    ->width(80),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('tier')
                    ->colors([
                        'warning' => 'platinum',
                        'success' => 'gold',
                        'info' => 'silver',
                        'danger' => 'bronze',
                        'secondary' => 'media_partner',
                    ])
                    ->formatStateUsing(fn (string $state): string => Sponsor::tierOptions()[$state] ?? $state),

                Tables\Columns\TextColumn::make('website_url')
                    ->label('Website')
                    ->limit(40)
                    ->url(fn ($record) => $record->website_url)
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Updated'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('tier')
                    ->options(Sponsor::tierOptions()),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
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
            'index' => Pages\ListSponsors::route('/'),
            'create' => Pages\CreateSponsor::route('/create'),
            'edit' => Pages\EditSponsor::route('/{record}/edit'),
        ];
    }
}
