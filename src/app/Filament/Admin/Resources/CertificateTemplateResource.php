<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CertificateTemplateResource\Pages;
use App\Models\CertificateTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                                'winner' => 'Winner (Achievement)',
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
                            ->required()
                            ->directory('certificates/templates')
                            ->imagePreviewHeight('300')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Name Text Position & Style')
                    ->description('Configure where participant name appears on the certificate (in % from top-left)')
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

                Forms\Components\Section::make('Rank Text Position & Style (Winner Only)')
                    ->description('Configure where the rank/placement text appears on winner certificates')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'winner')
                    ->schema([
                        Forms\Components\TextInput::make('rank_x')
                            ->label('X Position (%)')
                            ->numeric()
                            ->default(50)
                            ->minValue(0)
                            ->maxValue(100),

                        Forms\Components\TextInput::make('rank_y')
                            ->label('Y Position (%)')
                            ->numeric()
                            ->default(70)
                            ->minValue(0)
                            ->maxValue(100),

                        Forms\Components\TextInput::make('rank_font_size')
                            ->label('Font Size (px)')
                            ->numeric()
                            ->default(28),

                        Forms\Components\ColorPicker::make('rank_color')
                            ->label('Text Color')
                            ->default('#E8A317'),
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
                        'winner' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'participation' => 'Participation',
                        'winner' => 'Winner',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('competitionCategory.name')
                    ->label('Category')
                    ->placeholder('General')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('background_image')
                    ->label('Preview')
                    ->height(60),

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
