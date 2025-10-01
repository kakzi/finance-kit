<?php

namespace App\Filament\Resources\ReturnPembelianResource\Pages;

use App\Filament\Resources\ReturnPembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReturnPembelian extends CreateRecord
{
    protected static string $resource = ReturnPembelianResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
