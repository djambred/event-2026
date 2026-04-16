<?php

namespace App\Filament\Admin\Resources\RegistrationResource\Pages;

use App\Filament\Admin\Resources\RegistrationResource;
use App\Models\Registration;
use App\Services\CertificateService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generateAllParticipationCerts')
                ->label('Generate All Participation Certificates')
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

            Actions\CreateAction::make(),
        ];
    }
}
