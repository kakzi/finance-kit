<?php

namespace App\Filament\Resources\PengirimanResource\Pages;

use App\Filament\Resources\PengirimanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePengiriman extends CreateRecord
{
    protected static string $resource = PengirimanResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
