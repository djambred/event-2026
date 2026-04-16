<?php

namespace App\Filament\Admin\Resources\CompetitionCategoryResource\Pages;

use App\Filament\Admin\Resources\CompetitionCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompetitionCategory extends EditRecord
{
    protected static string $resource = CompetitionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
