<?php

namespace App\Filament\Resources\FakturPembelianResource\Pages;

use App\Filament\Resources\FakturPembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFakturPembelian extends EditRecord
{
    protected static string $resource = FakturPembelianResource::class;

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
