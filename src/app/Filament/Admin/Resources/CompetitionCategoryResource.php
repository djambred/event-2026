<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompetitionCategoryResource\Pages;
use App\Models\CompetitionCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CompetitionCategoryResource extends Resource
{
    protected static ?string $model = CompetitionCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('icon')
                            ->placeholder('e.g. auto_stories, record_voice_over')
                            ->helperText('Material Symbols icon name'),

                        Forms\Components\Select::make('type')
                            ->options([
                                'individual' => 'Individual',
                                'group' => 'Group',
                            ])
                            ->default('individual')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Pricing & Availability')
                    ->schema([
                        Forms\Components\Toggle::make('is_national')
                            ->label('Available for National')
                            ->default(false),

                        Forms\Components\TextInput::make('price_national')
                            ->label('Price (National)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),

                        Forms\Components\Toggle::make('is_international')
                            ->label('Available for International')
                            ->default(false),

                        Forms\Components\TextInput::make('price_international')
                            ->label('Price (International)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'individual' => 'info',
                        'group' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('price_national')
                    ->label('Price (Nas)')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_national')
                    ->label('National')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_international')
                    ->label('International')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('registrations_count')
                    ->counts('registrations')
                    ->label('Registrants')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
                Tables\Filters\TernaryFilter::make('is_national')
                    ->label('National'),
                Tables\Filters\TernaryFilter::make('is_international')
                    ->label('International'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompetitionCategories::route('/'),
            'create' => Pages\CreateCompetitionCategory::route('/create'),
            'edit' => Pages\EditCompetitionCategory::route('/{record}/edit'),
        ];
    }
}
