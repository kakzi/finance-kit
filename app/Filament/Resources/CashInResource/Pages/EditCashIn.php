<?php

namespace App\Filament\Resources\CashInResource\Pages;

use App\Filament\Resources\CashInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCashIn extends EditRecord
{
    protected static string $resource = CashInResource::class;

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
