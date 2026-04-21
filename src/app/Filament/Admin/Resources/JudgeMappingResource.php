<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JudgeMappingResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JudgeMappingResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Judge Mapping';

    protected static ?string $modelLabel = 'Judge Mapping';

    protected static ?string $pluralModelLabel = 'Judge Mapping';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('roles', fn (Builder $query) => $query->where('name', 'jury'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Judge Account')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('email')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Competition Assignment')
                    ->description('Plot kategori lomba yang boleh dinilai oleh juri ini.')
                    ->schema([
                        Forms\Components\Select::make('assignedCompetitionCategories')
                            ->relationship('assignedCompetitionCategories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Assigned Competition Categories'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignedCompetitionCategories.name')
                    ->label('Mapped Categories')
                    ->badge()
                    ->separator(', ')
                    ->wrap(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('without_category')
                    ->label('Belum dipetakan')
                    ->query(fn (Builder $query) => $query->doesntHave('assignedCompetitionCategories')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJudgeMappings::route('/'),
            'edit' => Pages\EditJudgeMapping::route('/{record}/edit'),
        ];
    }
}
