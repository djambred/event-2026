<?php

namespace App\Filament\Admin\Resources\RegistrationResource\Pages;

use App\Filament\Admin\Resources\RegistrationResource;
use App\Models\CompetitionCategory;
use App\Models\JudgingCriteria;
use App\Models\Registration;
use App\Models\Score;
use App\Services\CertificateService;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('exportScoringTemplate')
                ->label('Export Scoring')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->form([
                    Forms\Components\Select::make('category_id')
                        ->label('Competition Category')
                        ->options(CompetitionCategory::where('is_active', true)->pluck('name', 'id'))
                        ->required(),
                    Forms\Components\Select::make('round')
                        ->label('Round')
                        ->options([
                            'selection' => 'Seleksi',
                            'grandfinal' => 'Grand Final',
                        ])
                        ->default('selection')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $categoryId = $data['category_id'];
                    $round = $data['round'];
                    $category = CompetitionCategory::findOrFail($categoryId);
                    $criterias = JudgingCriteria::where('competition_category_id', $categoryId)
                        ->orderBy('sort_order')
                        ->get();

                    $query = Registration::where('competition_category_id', $categoryId)
                        ->where('status', 'confirmed');

                    if ($round === 'grandfinal') {
                        $query->where('stage', 'finalist');
                    }

                    $registrations = $query->orderBy('full_name')->get();

                    if ($registrations->isEmpty()) {
                        Notification::make()
                            ->title('No participants found')
                            ->warning()
                            ->send();
                        return;
                    }

                    $filename = 'scoring_' . $round . '_' . str_replace(' ', '_', strtolower($category->name)) . '_' . date('Ymd_His') . '.csv';

                    return response()->streamDownload(function () use ($registrations, $criterias, $round) {
                        $handle = fopen('php://output', 'w');

                        // BOM for Excel UTF-8
                        fwrite($handle, "\xEF\xBB\xBF");

                        // Header row
                        $headers = ['registration_id', 'full_name', 'email', 'institution', 'youtube_url', 'round'];
                        foreach ($criterias as $criteria) {
                            $headers[] = 'score__' . $criteria->id . '__' . $criteria->name . ' (weight:' . $criteria->weight . '%)';
                        }
                        $headers[] = 'notes';
                        fputcsv($handle, $headers);

                        // Data rows
                        foreach ($registrations as $reg) {
                            $row = [
                                $reg->id,
                                $reg->full_name,
                                $reg->email,
                                $reg->institution,
                                $reg->youtube_url ?? '',
                                $round,
                            ];
                            foreach ($criterias as $criteria) {
                                $score = $reg->scores()
                                    ->where('judging_criteria_id', $criteria->id)
                                    ->where('round', $round)
                                    ->first();
                                $row[] = $score ? $score->score : '';
                            }
                            $row[] = '';
                            fputcsv($handle, $row);
                        }

                        fclose($handle);
                    }, $filename, [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                    ]);
                }),

            Actions\Action::make('importScores')
                ->label('Import Scores')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->form([
                    Forms\Components\FileUpload::make('csv_file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                        ->required()
                        ->disk('local')
                        ->directory('temp-imports')
                        ->helperText('Upload the CSV file exported from "Export Scoring". Fill in the score columns (0-10) before uploading.'),
                ])
                ->requiresConfirmation()
                ->modalDescription('This will import scores from the CSV file. Round is auto-detected from the CSV. Existing scores will be updated.')
                ->action(function (array $data) {
                    $path = storage_path('app/' . $data['csv_file']);

                    if (!file_exists($path)) {
                        Notification::make()->title('File not found')->danger()->send();
                        return;
                    }

                    $handle = fopen($path, 'r');

                    // Skip BOM
                    $bom = fread($handle, 3);
                    if ($bom !== "\xEF\xBB\xBF") {
                        rewind($handle);
                    }

                    $headers = fgetcsv($handle);
                    if (!$headers) {
                        fclose($handle);
                        @unlink($path);
                        Notification::make()->title('Invalid CSV file')->danger()->send();
                        return;
                    }

                    // Parse criteria IDs from headers: "score__ID__Name (weight:X%)"
                    $criteriaColumns = [];
                    $roundIndex = array_search('round', $headers);
                    foreach ($headers as $index => $header) {
                        if (preg_match('/^score__(\d+)__/', $header, $m)) {
                            $criteriaColumns[$index] = (int) $m[1];
                        }
                    }

                    $notesIndex = array_search('notes', $headers);
                    $updated = 0;
                    $created = 0;
                    $skipped = 0;

                    while (($row = fgetcsv($handle)) !== false) {
                        $regId = (int) ($row[0] ?? 0);
                        if (!$regId) {
                            $skipped++;
                            continue;
                        }

                        $registration = Registration::find($regId);
                        if (!$registration) {
                            $skipped++;
                            continue;
                        }

                        // Detect round from CSV row, default to 'selection'
                        $round = ($roundIndex !== false && isset($row[$roundIndex]) && trim($row[$roundIndex]) !== '')
                            ? trim($row[$roundIndex])
                            : 'selection';

                        $rowNotes = ($notesIndex !== false && isset($row[$notesIndex])) ? trim($row[$notesIndex]) : null;

                        foreach ($criteriaColumns as $colIndex => $criteriaId) {
                            $scoreVal = isset($row[$colIndex]) ? trim($row[$colIndex]) : '';
                            if ($scoreVal === '') continue;

                            $scoreVal = (float) $scoreVal;
                            if ($scoreVal < 0 || $scoreVal > 10) {
                                $skipped++;
                                continue;
                            }

                            $existing = Score::where('registration_id', $regId)
                                ->where('judging_criteria_id', $criteriaId)
                                ->where('round', $round)
                                ->first();

                            if ($existing) {
                                $existing->update([
                                    'score' => $scoreVal,
                                    'notes' => $rowNotes ?: $existing->notes,
                                    'scored_by' => auth()->id(),
                                ]);
                                $updated++;
                            } else {
                                Score::create([
                                    'registration_id' => $regId,
                                    'judging_criteria_id' => $criteriaId,
                                    'round' => $round,
                                    'score' => $scoreVal,
                                    'notes' => $rowNotes,
                                    'scored_by' => auth()->id(),
                                ]);
                                $created++;
                            }
                        }
                    }

                    fclose($handle);
                    @unlink($path);

                    Notification::make()
                        ->title("Import complete: {$created} created, {$updated} updated, {$skipped} skipped")
                        ->success()
                        ->persistent()
                        ->send();
                }),
            Actions\Action::make('generateAllParticipationCerts')
                ->label('Generate Certificates')
                ->icon('heroicon-o-document-check')
                ->color('info')
                ->requiresConfirmation()
                ->modalDescription('This will generate participation certificates for ALL confirmed registrations that don\'t have one yet.')
                ->action(function () {
                    $registrations = Registration::where('status', 'confirmed')
                        ->whereNull('participation_certificate')
                        ->get();

                    if ($registrations->isEmpty()) {
                        Notification::make()
                            ->title('No pending certificates to generate')
                            ->body('All confirmed participants already have participation certificates.')
                            ->warning()
                            ->send();
                        return;
                    }

                    $certService = app(CertificateService::class);
                    $success = 0;
                    $failed = 0;

                    foreach ($registrations as $registration) {
                        try {
                            $path = $certService->generate($registration, 'participation');
                            $registration->update(['participation_certificate' => $path]);
                            $success++;
                        } catch (\Exception $e) {
                            $failed++;
                        }
                    }

                    Notification::make()
                        ->title("Participation certificates generated: {$success} success, {$failed} failed")
                        ->success()
                        ->send();
                }),

            Actions\Action::make('advanceFinalists')
                ->label('Advance Finalists')
                ->icon('heroicon-o-trophy')
                ->color('success')
                ->form([
                    Forms\Components\Select::make('category_id')
                        ->label('Competition Category')
                        ->options(CompetitionCategory::where('is_active', true)->pluck('name', 'id'))
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Forms\Set $set) => $set('top_n', null)),
                    Forms\Components\TextInput::make('top_n')
                        ->label('Jumlah Finalis (Top N)')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->helperText(function (Forms\Get $get) {
                            $catId = $get('category_id');
                            if (!$catId) return 'Pilih kategori dulu.';
                            $total = Registration::where('competition_category_id', $catId)
                                ->where('status', 'confirmed')
                                ->whereNotNull('final_score')
                                ->count();
                            return "Total peserta yang sudah dinilai: {$total}";
                        }),
                ])
                ->requiresConfirmation()
                ->modalDescription('Peserta dengan ranking tertinggi akan otomatis di-advance ke tahap Grand Final. Peserta lainnya akan di-set sebagai eliminated.')
                ->action(function (array $data) {
                    $categoryId = $data['category_id'];
                    $topN = (int) $data['top_n'];

                    // Get scored & confirmed registrations ordered by rank
                    $registrations = Registration::where('competition_category_id', $categoryId)
                        ->where('status', 'confirmed')
                        ->whereNotNull('final_score')
                        ->orderBy('rank', 'asc')
                        ->get();

                    if ($registrations->isEmpty()) {
                        Notification::make()
                            ->title('Tidak ada peserta yang sudah dinilai di kategori ini')
                            ->warning()
                            ->send();
                        return;
                    }

                    $advanced = 0;
                    $eliminated = 0;

                    foreach ($registrations as $reg) {
                        if ($reg->rank && $reg->rank <= $topN) {
                            $reg->update(['stage' => 'finalist']);
                            $advanced++;
                        } else {
                            $reg->update(['stage' => 'eliminated']);
                            $eliminated++;
                        }
                    }

                    $category = CompetitionCategory::find($categoryId);
                    Notification::make()
                        ->title("{$category->name}: {$advanced} finalis lolos, {$eliminated} tidak lolos")
                        ->success()
                        ->persistent()
                        ->send();
                }),

            //Actions\CreateAction::make(),
        ];
    }
}
