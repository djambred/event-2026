<?php

namespace App\Filament\Admin\Resources\RegistrationResource\RelationManagers;

use App\Models\JudgingCriteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ScoresRelationManager extends RelationManager
{
    protected static string $relationship = 'scores';

    protected static ?string $title = 'Scoring';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('judging_criteria_id')
                    ->label('Criteria')
                    ->options(function () {
                        $registration = $this->getOwnerRecord();
                        return JudgingCriteria::where('competition_category_id', $registration->competition_category_id)
                            ->orderBy('sort_order')
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->disabledOn('edit'),

                Forms\Components\TextInput::make('score')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01),

                Forms\Components\Textarea::make('notes')
                    ->rows(2),

                Forms\Components\Hidden::make('scored_by')
                    ->default(fn () => auth()->id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judgingCriteria.name')
                    ->label('Criteria'),

                Tables\Columns\TextColumn::make('judgingCriteria.weight')
                    ->label('Weight')
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('score')
                    ->sortable(),

                Tables\Columns\TextColumn::make('notes')
                    ->limit(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('scorer.name')
                    ->label('Scored By')
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['scored_by'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
