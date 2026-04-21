<?php

namespace App\Filament\Admin\Resources\JudgeMappingResource\Pages;

use App\Filament\Admin\Resources\JudgeMappingResource;
use Filament\Resources\Pages\EditRecord;

class EditJudgeMapping extends EditRecord
{
    protected static string $resource = JudgeMappingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
