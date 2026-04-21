<?php

namespace App\Filament\Admin\Resources\RegistrationResource\RelationManagers;

use App\Models\JudgingCriteria;
use App\Models\Score;
use App\Models\Registration;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class ScoresRelationManager extends RelationManager
{
    protected static string $relationship = 'scores';

    protected static ?string $title = 'Scoring';

    #[Url]
    public string $activeRound = 'selection';

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
                    ->default(fn () => Auth::id()),

                Forms\Components\Hidden::make('round')
                    ->default(fn () => $this->activeRound),
            ]);
    }

    public function table(Table $table): Table
    {
        $isGrandfinal = $this->activeRound === 'grandfinal';
        $registration = $this->getOwnerRecord();
        $isFinalist = in_array($registration->stage, ['finalist', 'grandfinal']);
        $authUser = Auth::user();
        $isJury = $authUser instanceof User && $authUser->hasRole('jury');

        return $table
            ->modifyQueryUsing(function ($query) use ($isJury) {
                $query->where('round', $this->activeRound);

                if ($isJury) {
                    $query->where('scored_by', Auth::id());
                }

                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('round')
                    ->badge()
                    ->color(fn (string $state) => $state === 'grandfinal' ? 'success' : 'gray')
                    ->formatStateUsing(fn (string $state) => $state === 'grandfinal' ? 'Grand Final' : 'Seleksi')
                    ->toggleable(isToggledHiddenByDefault: true),

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
                    ->getStateUsing(fn ($record) => floatval(number_format($record->score * $record->judgingCriteria->weight / 100, 2)))
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
                // Round switcher
                Tables\Actions\Action::make('switchToSelection')
                    ->label('📋 Seleksi')
                    ->color($isGrandfinal ? 'gray' : 'primary')
                    ->badge($isGrandfinal ? null : 'Active')
                    ->action(fn () => $this->activeRound = 'selection'),

                Tables\Actions\Action::make('switchToGrandfinal')
                    ->label('🏆 Grand Final')
                    ->color($isGrandfinal ? 'primary' : 'gray')
                    ->badge($isGrandfinal ? 'Active' : null)
                    ->visible($isFinalist)
                    ->action(fn () => $this->activeRound = 'grandfinal'),

                Tables\Actions\Action::make('initializeScores')
                    ->label('Initialize All Criteria')
                    ->icon('heroicon-o-plus-circle')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalDescription(fn () => 'Create score entries (0) for all criteria in round: ' . ($isGrandfinal ? 'Grand Final' : 'Seleksi'))
                    ->action(function () {
                        $registration = $this->getOwnerRecord();
                        $criterias = JudgingCriteria::where('competition_category_id', $registration->competition_category_id)
                            ->orderBy('sort_order')
                            ->get();

                        $created = 0;
                        foreach ($criterias as $criteria) {
                            $exists = Score::where('registration_id', $registration->id)
                                ->where('judging_criteria_id', $criteria->id)
                                ->where('round', $this->activeRound)
                                ->where('scored_by', Auth::id())
                                ->exists();

                            if (!$exists) {
                                Score::create([
                                    'registration_id' => $registration->id,
                                    'judging_criteria_id' => $criteria->id,
                                    'round' => $this->activeRound,
                                    'score' => 0,
                                    'scored_by' => Auth::id(),
                                ]);
                                $created++;
                            }
                        }

                        Notification::make()
                            ->title($created > 0 ? "{$created} score entries created" : 'All criteria already initialized')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('batchJuryScoreInput')
                    ->label('Input Nilai Semua Juri')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->slideOver()
                    ->visible(fn () => ! $isJury)
                    ->form(function () {
                        $registration = $this->getOwnerRecord();
                        $criterias = JudgingCriteria::where('competition_category_id', $registration->competition_category_id)
                            ->orderBy('sort_order')
                            ->get();
                        $judges = $registration->competitionCategory->judges()->orderBy('name')->get();

                        if ($judges->isEmpty()) {
                            return [
                                Forms\Components\Placeholder::make('no_judges_notice')
                                    ->label('')
                                    ->content('Belum ada juri yang di-assign ke kategori ini. Atur melalui menu Judge Mapping terlebih dahulu.'),
                            ];
                        }

                        $judgeList = $judges->values();
                        $round = $this->activeRound;

                        $schema = [
                            Forms\Components\Placeholder::make('round_info')
                                ->label('Round')
                                ->content($round === 'grandfinal' ? '🏆 Grand Final' : '📋 Seleksi'),
                        ];

                        foreach ($criterias as $criteria) {
                            $juryInputs = [];
                            foreach ($judgeList as $index => $judge) {
                                $existingScore = Score::where('registration_id', $registration->id)
                                    ->where('judging_criteria_id', $criteria->id)
                                    ->where('round', $round)
                                    ->where('scored_by', $judge->id)
                                    ->value('score');

                                $juryInputs[] = Forms\Components\TextInput::make("score_{$criteria->id}_{$judge->id}")
                                    ->label('Juri ' . ($index + 1) . ' — ' . $judge->name)
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(10)
                                    ->step(0.01)
                                    ->default($existingScore !== null ? (string) $existingScore : null)
                                    ->placeholder('0 – 10')
                                    ->suffix('/ 10');
                            }

                            $schema[] = Forms\Components\Section::make($criteria->name)
                                ->description('Bobot: ' . floatval($criteria->weight) . '%')
                                ->schema($juryInputs)
                                ->columns($judgeList->count());
                        }

                        return $schema;
                    })
                    ->action(function (array $data) {
                        $registration = $this->getOwnerRecord();
                        $criterias = JudgingCriteria::where('competition_category_id', $registration->competition_category_id)
                            ->get();
                        $judges = $registration->competitionCategory->judges()->get();
                        $saved = 0;

                        foreach ($criterias as $criteria) {
                            foreach ($judges as $judge) {
                                $key = "score_{$criteria->id}_{$judge->id}";
                                if (array_key_exists($key, $data) && $data[$key] !== null && $data[$key] !== '') {
                                    Score::updateOrCreate(
                                        [
                                            'registration_id' => $registration->id,
                                            'judging_criteria_id' => $criteria->id,
                                            'round' => $this->activeRound,
                                            'scored_by' => $judge->id,
                                        ],
                                        ['score' => (float) $data[$key]]
                                    );
                                    $saved++;
                                }
                            }
                        }

                        Notification::make()
                            ->title("{$saved} nilai berhasil disimpan")
                            ->body('Gunakan tombol "Calculate Final Score" untuk menghitung skor akhir.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('calculateFinalScore')
                    ->label(fn () => $isGrandfinal ? 'Calculate Grand Final Score' : 'Calculate Final Score')
                    ->icon('heroicon-o-calculator')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn () => ! $isJury)
                    ->action(function () use ($isGrandfinal) {
                        $registration = $this->getOwnerRecord();

                        if ($isGrandfinal) {
                            $score = $registration->calculateGrandfinalScore();
                            $registration->update(['grandfinal_score' => $score]);

                            // Recalculate grand final ranks for the category
                            $regs = Registration::where('competition_category_id', $registration->competition_category_id)
                                ->where('status', 'confirmed')
                                ->where('stage', 'finalist')
                                ->whereNotNull('grandfinal_score')
                                ->orderByDesc('grandfinal_score')
                                ->get();

                            foreach ($regs as $index => $reg) {
                                $reg->update(['grandfinal_rank' => $index + 1]);
                            }

                            $registration->refresh();

                            Notification::make()
                                ->title("Grand Final Score: {$score} | Rank: #{$registration->grandfinal_rank}")
                                ->success()
                                ->persistent()
                                ->send();
                        } else {
                            $score = $registration->calculateFinalScore('selection');
                            $registration->update(['final_score' => $score]);

                            // Recalculate selection ranks for the category
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
                                ->title("Final Score: {$score} | Rank: #{$registration->rank}")
                                ->success()
                                ->persistent()
                                ->send();
                        }
                    }),

                Tables\Actions\CreateAction::make()
                    ->label('Add Single Score')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['scored_by'] = Auth::id();
                        $data['round'] = $this->activeRound;
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => ! $isJury),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => ! $isJury),
            ]);
    }
}
