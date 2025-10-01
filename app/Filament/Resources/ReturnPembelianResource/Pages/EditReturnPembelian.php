<?php

namespace App\Filament\Resources\ReturnPembelianResource\Pages;

use App\Filament\Resources\ReturnPembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturnPembelian extends EditRecord
{
    protected static string $resource = ReturnPembelianResource::class;

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
