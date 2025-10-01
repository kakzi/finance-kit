<?php

namespace App\Filament\Resources\ApprovalRequestResource\Pages;

use App\Filament\Resources\ApprovalRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovalRequest extends EditRecord
{
    protected static string $resource = ApprovalRequestResource::class;

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
