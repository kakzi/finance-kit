<?php

namespace App\Filament\Resources\PenerimaanBarangResource\Pages;

use App\Filament\Resources\PenerimaanBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePenerimaanBarang extends CreateRecord
{
    protected static string $resource = PenerimaanBarangResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
