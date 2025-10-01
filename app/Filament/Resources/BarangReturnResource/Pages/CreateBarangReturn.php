<?php

namespace App\Filament\Resources\BarangReturnResource\Pages;

use App\Filament\Resources\BarangReturnResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBarangReturn extends CreateRecord
{
    protected static string $resource = BarangReturnResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
