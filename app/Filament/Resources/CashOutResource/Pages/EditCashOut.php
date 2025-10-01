<?php

namespace App\Filament\Resources\CashOutResource\Pages;

use App\Filament\Resources\CashOutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCashOut extends EditRecord
{
    protected static string $resource = CashOutResource::class;

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
