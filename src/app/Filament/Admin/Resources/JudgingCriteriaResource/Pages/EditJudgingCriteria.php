<?php

namespace App\Filament\Admin\Resources\JudgingCriteriaResource\Pages;

use App\Filament\Admin\Resources\JudgingCriteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJudgingCriteria extends EditRecord
{
    protected static string $resource = JudgingCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
