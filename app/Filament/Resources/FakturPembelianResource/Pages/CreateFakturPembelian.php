<?php

namespace App\Filament\Resources\FakturPembelianResource\Pages;

use App\Filament\Resources\FakturPembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFakturPembelian extends CreateRecord
{
    protected static string $resource = FakturPembelianResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
