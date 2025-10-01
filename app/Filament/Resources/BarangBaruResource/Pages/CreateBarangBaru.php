<?php

namespace App\Filament\Resources\BarangBaruResource\Pages;

use App\Filament\Resources\BarangBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBarangBaru extends CreateRecord
{
    protected static string $resource = BarangBaruResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
