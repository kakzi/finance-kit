<?php

namespace App\Filament\Resources\LevelApprovalResource\Pages;

use App\Filament\Resources\LevelApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLevelApproval extends EditRecord
{
    protected static string $resource = LevelApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
