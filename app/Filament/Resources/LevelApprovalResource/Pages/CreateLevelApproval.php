<?php

namespace App\Filament\Resources\LevelApprovalResource\Pages;

use App\Filament\Resources\LevelApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLevelApproval extends CreateRecord
{
    protected static string $resource = LevelApprovalResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
