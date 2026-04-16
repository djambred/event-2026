<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JudgingCriteriaResource\Pages;
use App\Models\JudgingCriteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JudgingCriteriaResource extends Resource
{
    protected static ?string $model = JudgingCriteria::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?string $navigationLabel = 'Judging Criteria';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('competition_category_id')
                            ->relationship('competitionCategory', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Content & Creativity'),

                        Forms\Components\Textarea::make('description')
                            ->rows(2)
                            ->placeholder('Describe what this criteria evaluates'),

                        Forms\Components\TextInput::make('weight')
                            ->required()
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->placeholder('e.g. 30'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
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

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('weight')
                    ->suffix('%')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('competition_category_id')
            ->groups([
                Tables\Grouping\Group::make('competitionCategory.name')
                    ->label('Category'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('competition_category_id')
                    ->relationship('competitionCategory', 'name')
                    ->label('Category'),
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
            'index' => Pages\ListJudgingCriterias::route('/'),
            'create' => Pages\CreateJudgingCriteria::route('/create'),
            'edit' => Pages\EditJudgingCriteria::route('/{record}/edit'),
        ];
    }
}
