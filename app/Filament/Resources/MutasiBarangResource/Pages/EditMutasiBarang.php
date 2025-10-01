<?php

namespace App\Filament\Resources\MutasiBarangResource\Pages;

use App\Filament\Resources\MutasiBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMutasiBarang extends EditRecord
{
    protected static string $resource = MutasiBarangResource::class;

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
