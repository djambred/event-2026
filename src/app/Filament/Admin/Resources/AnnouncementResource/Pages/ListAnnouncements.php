<?php

namespace App\Filament\Admin\Resources\AnnouncementResource\Pages;

use App\Filament\Admin\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\Models\CompetitionCategory;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListAnnouncements extends ListRecords
{
    protected static string $resource = AnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('importAnnouncementsCsv')
                ->label('Import CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->form([
                    Forms\Components\FileUpload::make('csv_file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                        ->required()
                        ->disk('local')
                        ->directory('temp-imports')
                        ->helperText('Headers: competition_category_slug OR competition_category_id, type, title, description, zoom_url, winners_count, is_published, published_at'),
                ])
                ->requiresConfirmation()
                ->modalDescription('Import bulk announcements from CSV. Existing rows with the same category + type + title will be updated.')
                ->action(function (array $data): void {
                    $path = storage_path('app/' . $data['csv_file']);

                    if (!file_exists($path)) {
                        Notification::make()->title('File not found')->danger()->send();

                        return;
                    }

                    $handle = fopen($path, 'r');
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

                    $headerIndexes = array_flip(array_map(static fn ($h) => trim((string) $h), $headers));
                    $required = ['type', 'title'];
                    foreach ($required as $requiredHeader) {
                        if (!array_key_exists($requiredHeader, $headerIndexes)) {
                            fclose($handle);
                            @unlink($path);
                            Notification::make()->title('Missing required header: ' . $requiredHeader)->danger()->send();

                            return;
                        }
                    }

                    $created = 0;
                    $updated = 0;
                    $skipped = 0;

                    while (($row = fgetcsv($handle)) !== false) {
                        $slug = $this->getCsvValue($row, $headerIndexes, 'competition_category_slug');
                        $categoryId = (int) $this->getCsvValue($row, $headerIndexes, 'competition_category_id');

                        if ($slug !== '') {
                            $categoryId = (int) CompetitionCategory::where('slug', $slug)->value('id');
                        }

                        if ($categoryId <= 0) {
                            $skipped++;
                            continue;
                        }

                        $type = strtolower($this->getCsvValue($row, $headerIndexes, 'type'));
                        $title = $this->getCsvValue($row, $headerIndexes, 'title');

                        if (!in_array($type, ['info', 'zoom', 'winner'], true) || $title === '') {
                            $skipped++;
                            continue;
                        }

                        $values = [
                            'description' => $this->getCsvValue($row, $headerIndexes, 'description') ?: null,
                            'zoom_url' => $this->getCsvValue($row, $headerIndexes, 'zoom_url') ?: null,
                            'winners_count' => max(1, min(10, (int) ($this->getCsvValue($row, $headerIndexes, 'winners_count') ?: 3))),
                            'is_published' => $this->toBoolean($this->getCsvValue($row, $headerIndexes, 'is_published')),
                            'published_at' => $this->parsePublishedAt($this->getCsvValue($row, $headerIndexes, 'published_at')),
                        ];

                        if ($type !== 'zoom') {
                            $values['zoom_url'] = null;
                        }

                        if ($type !== 'winner') {
                            $values['winners_count'] = null;
                        }

                        $announcement = Announcement::where('competition_category_id', $categoryId)
                            ->where('type', $type)
                            ->where('title', $title)
                            ->first();

                        if ($announcement) {
                            $announcement->update($values);
                            $updated++;
                        } else {
                            Announcement::create([
                                'competition_category_id' => $categoryId,
                                'type' => $type,
                                'title' => $title,
                                ...$values,
                            ]);
                            $created++;
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
            Actions\CreateAction::make(),
        ];
    }

    private function getCsvValue(array $row, array $headerIndexes, string $key): string
    {
        if (!array_key_exists($key, $headerIndexes)) {
            return '';
        }

        return trim((string) ($row[$headerIndexes[$key]] ?? ''));
    }

    private function toBoolean(string $value): bool
    {
        return in_array(strtolower($value), ['1', 'true', 'yes', 'y', 'published'], true);
    }

    private function parsePublishedAt(string $value): ?string
    {
        if ($value === '') {
            return null;
        }

        try {
            return \Illuminate\Support\Carbon::parse($value)->toDateTimeString();
        } catch (\Throwable) {
            return null;
        }
    }
}
