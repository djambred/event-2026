<?php

namespace App\Filament\Admin\Resources\RegistrationResource\RelationManagers;

use App\Models\JudgingCriteria;
use App\Models\Score;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
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
                    ->maxValue(10)
                    ->step(0.01)
                    ->helperText('Score range: 0 - 10'),

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
                    ->label('Criteria')
                    ->sortable(),

                Tables\Columns\TextColumn::make('judgingCriteria.weight')
                    ->label('Weight')
                    ->suffix('%')
                    ->alignCenter(),

                Tables\Columns\TextInputColumn::make('score')
                    ->rules(['required', 'numeric', 'min:0', 'max:10'])
                    ->sortable()
                    ->alignCenter()
                    ->extraAttributes(['style' => 'max-width: 80px']),

                Tables\Columns\TextColumn::make('weighted_score')
                    ->label('Weighted')
                    ->getStateUsing(fn ($record) => number_format($record->score * $record->judgingCriteria->weight / 100, 2))
                    ->alignCenter()
                    ->tooltip('Score × Weight / 100'),

                Tables\Columns\TextColumn::make('notes')
                    ->limit(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('scorer.name')
                    ->label('Scored By')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                Tables\Actions\Action::make('initializeScores')
                    ->label('Initialize All Criteria')
                    ->icon('heroicon-o-plus-circle')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalDescription('This will create score entries (0) for all judging criteria in this category. You can then edit scores directly in the table.')
                    ->action(function () {
                        $registration = $this->getOwnerRecord();
                        $criterias = JudgingCriteria::where('competition_category_id', $registration->competition_category_id)
                            ->orderBy('sort_order')
                            ->get();

                        $created = 0;
                        foreach ($criterias as $criteria) {
                            $exists = Score::where('registration_id', $registration->id)
                                ->where('judging_criteria_id', $criteria->id)
                                ->exists();

                            if (!$exists) {
                                Score::create([
                                    'registration_id' => $registration->id,
                                    'judging_criteria_id' => $criteria->id,
                                    'score' => 0,
                                    'scored_by' => auth()->id(),
                                ]);
                                $created++;
                            }
                        }

                        Notification::make()
                            ->title($created > 0 ? "{$created} score entries created" : 'All criteria already initialized')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('calculateFinalScore')
                    ->label('Calculate Final Score')
                    ->icon('heroicon-o-calculator')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () {
                        $registration = $this->getOwnerRecord();
                        $finalScore = $registration->calculateFinalScore();
                        $registration->update(['final_score' => $finalScore]);

                        // Recalculate ranks for the category
                        $regs = Registration::where('competition_category_id', $registration->competition_category_id)
                            ->where('status', 'confirmed')
                            ->whereNotNull('final_score')
                            ->orderByDesc('final_score')
                            ->get();

                        foreach ($regs as $index => $reg) {
                            $reg->update(['rank' => $index + 1]);
                        }

                        $registration->refresh();

                        Notification::make()
                            ->title("Final Score: {$finalScore} | Rank: #{$registration->rank}")
                            ->success()
                            ->persistent()
                            ->send();
                    }),

                Tables\Actions\CreateAction::make()
                    ->label('Add Single Score')
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
