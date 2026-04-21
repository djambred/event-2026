<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CertificateTemplateResource\Pages;
use App\Models\CertificateTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateResource extends Resource
{
    protected static ?string $model = CertificateTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Template Info')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Participant Certificate - Storytelling'),

                        Forms\Components\Select::make('type')
                            ->options([
                                'participation' => 'Participation (Thank You)',
                            ])
                            ->required()
                            ->default('participation')
                            ->live(),

                        Forms\Components\Select::make('competition_category_id')
                            ->relationship('competitionCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Leave empty for a general certificate'),

                        Forms\Components\FileUpload::make('background_image')
                            ->label('Certificate Background Design')
                            ->image()
                            ->directory('certificates/templates')
                            ->imagePreviewHeight('300')
                            ->helperText('Optional. Leave empty to use the built-in HTML certificate design.')
                            ->columnSpanFull()
                            ->live(),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Text Style')
                    ->description('Configure font size and color for the text on the certificate')
                    ->visible(fn (Forms\Get $get): bool => empty($get('background_image')))
                    ->schema([
                        Forms\Components\TextInput::make('name_font_size')
                            ->label('Name Font Size (px)')
                            ->numeric()
                            ->default(36),

                        Forms\Components\ColorPicker::make('name_color')
                            ->label('Name Color')
                            ->default('#001d34'),

                        Forms\Components\TextInput::make('category_font_size')
                            ->label('Category Font Size (px)')
                            ->numeric()
                            ->default(18),

                        Forms\Components\ColorPicker::make('category_color')
                            ->label('Category Color')
                            ->default('#0574b9'),


                    ])->columns(4),

                Forms\Components\Section::make('Name Text Position & Style')
                    ->description('Configure where participant name appears on the certificate (in % from top-left)')
                    ->visible(fn (Forms\Get $get): bool => !empty($get('background_image')))
                    ->schema([
                        Forms\Components\TextInput::make('name_x')
                            ->label('X Position (%)')
                            ->numeric()
                            ->default(50)
                            ->minValue(0)
                            ->maxValue(100),

                        Forms\Components\TextInput::make('name_y')
                            ->label('Y Position (%)')
                            ->numeric()
                            ->default(50)
                            ->minValue(0)
                            ->maxValue(100),

                        Forms\Components\TextInput::make('name_font_size')
                            ->label('Font Size (px)')
                            ->numeric()
                            ->default(36),

                        Forms\Components\ColorPicker::make('name_color')
                            ->label('Text Color')
                            ->default('#000000'),
                    ])->columns(4),

                Forms\Components\Section::make('Category Text Position & Style')
                    ->description('Configure where competition category appears on the certificate')
                    ->visible(fn (Forms\Get $get): bool => !empty($get('background_image')))
                    ->schema([
                        Forms\Components\TextInput::make('category_x')
                            ->label('X Position (%)')
                            ->numeric()
                            ->default(50)
                            ->minValue(0)
                            ->maxValue(100),

                        Forms\Components\TextInput::make('category_y')
                            ->label('Y Position (%)')
                            ->numeric()
                            ->default(60)
                            ->minValue(0)
                            ->maxValue(100),

                        Forms\Components\TextInput::make('category_font_size')
                            ->label('Font Size (px)')
                            ->numeric()
                            ->default(24),

                        Forms\Components\ColorPicker::make('category_color')
                            ->label('Text Color')
                            ->default('#333333'),
                    ])->columns(4),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'participation' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'participation' => 'Participation',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('competitionCategory.name')
                    ->label('Category')
                    ->placeholder('General')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('background_image')
                    ->label('Preview')
                    ->height(60)
                    ->placeholder('HTML Default'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalContent(fn (CertificateTemplate $record) => view('filament.certificate-preview', ['template' => $record]))
                    ->modalHeading('Certificate Template Preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
                Tables\Actions\Action::make('downloadSample')
                    ->label('Sample PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (CertificateTemplate $record) {
                        $backgroundBase64 = null;

                        if ($record->background_image) {
                            $backgroundPath = Storage::disk('public')->path($record->background_image);
                            if (file_exists($backgroundPath)) {
                                $mime = mime_content_type($backgroundPath);
                                $base64 = base64_encode(file_get_contents($backgroundPath));
                                $backgroundBase64 = "data:{$mime};base64,{$base64}";
                            }
                        }

                        $sampleName = 'John Doe';
                        $sampleCategory = $record->competitionCategory?->name ?? 'Storytelling';
                        $sampleRank = '';

                        // Seal image
                        $sealPath = public_path('seal.png');
                        $sealBase64 = '';
                        if (file_exists($sealPath)) {
                            $sealMime = mime_content_type($sealPath);
                            $sealBase64 = 'data:' . $sealMime . ';base64,' . base64_encode(file_get_contents($sealPath));
                        }

                        $html = view('certificates.template', [
                            'template' => $record,
                            'backgroundBase64' => $backgroundBase64,
                            'sealBase64' => $sealBase64,
                            'participantName' => $sampleName,
                            'categoryName' => $sampleCategory,
                            'rankText' => $sampleRank,
                        ])->render();

                        $pdf = Pdf::loadHTML($html)
                            ->setPaper('a4', 'landscape')
                            ->setOption('isRemoteEnabled', true)
                            ->setOption('dpi', 150);

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'sample-' . \Illuminate\Support\Str::slug($record->name) . '.pdf',
                            ['Content-Type' => 'application/pdf']
                        );
                    }),
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
            'index' => Pages\ListCertificateTemplates::route('/'),
            'create' => Pages\CreateCertificateTemplate::route('/create'),
            'edit' => Pages\EditCertificateTemplate::route('/{record}/edit'),
        ];
    }
}
