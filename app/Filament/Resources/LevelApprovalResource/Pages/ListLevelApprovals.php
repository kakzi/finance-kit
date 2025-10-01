<?php

namespace App\Filament\Resources\LevelApprovalResource\Pages;

use App\Filament\Resources\LevelApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLevelApprovals extends ListRecords
{
    protected static string $resource = LevelApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
