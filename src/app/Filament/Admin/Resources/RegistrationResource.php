<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RegistrationResource\Pages;
use App\Filament\Admin\Resources\RegistrationResource\RelationManagers;
use App\Models\Registration;
use App\Services\CertificateService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registration Info')
                    ->schema([
                        Forms\Components\Select::make('registration_type')
                            ->options([
                                'national' => 'National',
                                'international' => 'International',
                            ])
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('whatsapp')
                            ->required()
                            ->tel()
                            ->placeholder('+628xxxxxxxxxx')
                            ->maxLength(30),

                        Forms\Components\TextInput::make('institution')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Competition')
                    ->schema([
                        Forms\Components\Select::make('competition_category_id')
                            ->relationship('competitionCategory', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

                Forms\Components\Section::make('Documents')
                    ->schema([
                        Forms\Components\FileUpload::make('school_uniform_photo')
                            ->label('School Uniform Photo')
                            ->image()
                            ->directory('registrations/uniform-photos')
                            ->visible(fn (Forms\Get $get): bool => $get('registration_type') === 'national'),

                        Forms\Components\FileUpload::make('student_id_document')
                            ->label('Student ID / Passport')
                            ->directory('registrations/id-documents')
                            ->visible(fn (Forms\Get $get): bool => $get('registration_type') === 'international'),

                        Forms\Components\FileUpload::make('formal_photo')
                            ->label('Formal Photo (3x4)')
                            ->image()
                            ->directory('registrations/formal-photos')
                            ->visible(fn (Forms\Get $get): bool => $get('registration_type') === 'international'),

                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Proof of Payment')
                            ->directory('registrations/payment-proofs')
                            ->visible(fn (Forms\Get $get): bool => $get('registration_type') === 'national'),
                    ]),

                Forms\Components\Section::make('Submission')
                    ->schema([
                        Forms\Components\TextInput::make('youtube_url')
                            ->label('YouTube Video URL')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->maxLength(500),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('registration_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'national' => 'info',
                        'international' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('whatsapp')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('institution')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('competitionCategory.name')
                    ->label('Category')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('stage')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'selection' => 'gray',
                        'finalist' => 'success',
                        'grandfinal' => 'warning',
                        'eliminated' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'selection' => 'Seleksi',
                        'finalist' => 'Finalist',
                        'grandfinal' => 'Grand Final',
                        'eliminated' => 'Eliminated',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('final_score')
                    ->label('Score')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('rank')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('grandfinal_score')
                    ->label('GF Score')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('grandfinal_rank')
                    ->label('GF Rank')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('youtube_url')
                    ->label('YouTube')
                    ->url(fn ($record) => $record->youtube_url, true)
                    ->icon('heroicon-o-play-circle')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('school_uniform_photo')
                    ->label('Uniform')
                    ->disk('public')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->circular(),

                Tables\Columns\ImageColumn::make('payment_proof')
                    ->label('Payment')
                    ->disk('public')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->circular(),

                Tables\Columns\ImageColumn::make('student_id_document')
                    ->label('Student ID')
                    ->disk('public')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->circular(),

                Tables\Columns\ImageColumn::make('formal_photo')
                    ->label('Formal Photo')
                    ->disk('public')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->circular(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('registration_type')
                    ->options([
                        'national' => 'National',
                        'international' => 'International',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('competition_category_id')
                    ->relationship('competitionCategory', 'name')
                    ->label('Category'),

                Tables\Filters\SelectFilter::make('stage')
                    ->options([
                        'selection' => 'Seleksi',
                        'finalist' => 'Finalist',
                        'grandfinal' => 'Grand Final',
                        'eliminated' => 'Eliminated',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record): bool => $record->status === 'pending')
                    ->action(fn (Registration $record) => $record->update(['status' => 'confirmed'])),

                Tables\Actions\Action::make('reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record): bool => $record->status === 'pending')
                    ->action(fn (Registration $record) => $record->update(['status' => 'rejected'])),

                Tables\Actions\Action::make('calculateScore')
                    ->label('Calculate Score')
                    ->icon('heroicon-o-calculator')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record): bool => $record->status === 'confirmed' && $record->scores()->exists())
                    ->action(function (Registration $record) {
                        $finalScore = $record->calculateFinalScore();
                        $record->update(['final_score' => $finalScore]);

                        // Recalculate ranks for the category
                        $registrations = Registration::where('competition_category_id', $record->competition_category_id)
                            ->where('status', 'confirmed')
                            ->whereNotNull('final_score')
                            ->orderByDesc('final_score')
                            ->get();

                        foreach ($registrations as $index => $reg) {
                            $reg->update(['rank' => $index + 1]);
                        }

                        Notification::make()
                            ->title('Score calculated: ' . $finalScore)
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('generateParticipationCert')
                    ->label('Participation Certificate')
                    ->icon('heroicon-o-document-check')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalDescription('Generate a participation/thank you certificate for this participant.')
                    ->visible(fn (Registration $record): bool => $record->status === 'confirmed')
                    ->action(function (Registration $record) {
                        try {
                            $path = app(CertificateService::class)->generate($record, 'participation');
                            $record->update(['participation_certificate' => $path]);
                            Notification::make()
                                ->title('Participation certificate generated')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Failed to generate certificate')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('generateWinnerCert')
                    ->label('Winner Certificate')
                    ->icon('heroicon-o-trophy')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalDescription('Generate a winner/achievement certificate for this participant.')
                    ->visible(fn (Registration $record): bool => $record->status === 'confirmed' && $record->final_score !== null && $record->rank !== null)
                    ->action(function (Registration $record) {
                        try {
                            $path = app(CertificateService::class)->generate($record, 'winner');
                            $record->update(['winner_certificate' => $path]);
                            Notification::make()
                                ->title('Winner certificate generated')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Failed to generate certificate')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('portalLink')
                    ->label('Portal URL')
                    ->icon('heroicon-o-link')
                    ->color('gray')
                    ->action(function (Registration $record) {
                        $url = $record->getPortalUrl();
                        Notification::make()
                            ->title('Participant Portal URL')
                            ->body($url)
                            ->success()
                            ->persistent()
                            ->send();
                    }),

                Tables\Actions\Action::make('viewDocuments')
                    ->label('Berkas')
                    ->icon('heroicon-o-folder-open')
                    ->color('info')
                    ->modalHeading(fn (Registration $record): string => 'Berkas - ' . $record->full_name)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (Registration $record) => view('filament.registration-documents', [
                        'registration' => $record,
                    ])),

                Tables\Actions\Action::make('resetRegisterKey')
                    ->label('Reset Register Key')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalDescription('This will generate a new Register Key for the participant. The new key will be shown once — make sure to copy it.')
                    ->action(function (Registration $record) {
                        $newKey = Registration::generateRegisterKey();
                        $record->update([
                            'password' => Hash::make($newKey),
                            'password_changed' => true,
                        ]);
                        Notification::make()
                            ->title('New Register Key Generated')
                            ->body($newKey)
                            ->success()
                            ->persistent()
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('bulkCalculateScores')
                        ->label('Calculate Scores & Ranks')
                        ->icon('heroicon-o-calculator')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalDescription('Calculate final scores and recalculate ranks for all selected registrations.')
                        ->deselectRecordsAfterCompletion()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $categoryIds = [];
                            foreach ($records as $record) {
                                if ($record->status === 'confirmed' && $record->scores()->exists()) {
                                    $finalScore = $record->calculateFinalScore();
                                    $record->update(['final_score' => $finalScore]);
                                    $categoryIds[$record->competition_category_id] = true;
                                }
                            }

                            // Recalculate ranks per category
                            foreach (array_keys($categoryIds) as $categoryId) {
                                $regs = Registration::where('competition_category_id', $categoryId)
                                    ->where('status', 'confirmed')
                                    ->whereNotNull('final_score')
                                    ->orderByDesc('final_score')
                                    ->get();
                                foreach ($regs as $index => $reg) {
                                    $reg->update(['rank' => $index + 1]);
                                }
                            }

                            Notification::make()
                                ->title('Scores calculated and ranks updated for ' . count($categoryIds) . ' categories')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('bulkGenerateParticipationCerts')
                        ->label('Generate Participation Certificates')
                        ->icon('heroicon-o-document-check')
                        ->color('info')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $success = 0;
                            $failed = 0;
                            $certService = app(CertificateService::class);
                            foreach ($records as $record) {
                                if ($record->status !== 'confirmed') continue;
                                try {
                                    $path = $certService->generate($record, 'participation');
                                    $record->update(['participation_certificate' => $path]);
                                    $success++;
                                } catch (\Exception $e) {
                                    $failed++;
                                }
                            }
                            Notification::make()
                                ->title("Participation certificates: {$success} generated, {$failed} failed")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ScoresRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'view' => Pages\ViewRegistration::route('/{record}'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
