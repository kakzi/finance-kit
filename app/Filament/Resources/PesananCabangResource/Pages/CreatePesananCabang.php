<?php

namespace App\Filament\Resources\PesananCabangResource\Pages;

use App\Filament\Resources\PesananCabangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePesananCabang extends CreateRecord
{
    protected static string $resource = PesananCabangResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
