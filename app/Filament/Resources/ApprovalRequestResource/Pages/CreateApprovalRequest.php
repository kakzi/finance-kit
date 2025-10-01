<?php

namespace App\Filament\Resources\ApprovalRequestResource\Pages;

use App\Filament\Resources\ApprovalRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovalRequest extends CreateRecord
{
    protected static string $resource = ApprovalRequestResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
