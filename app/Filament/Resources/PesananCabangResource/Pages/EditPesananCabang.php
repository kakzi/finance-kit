<?php

namespace App\Filament\Resources\PesananCabangResource\Pages;

use App\Filament\Resources\PesananCabangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesananCabang extends EditRecord
{
    protected static string $resource = PesananCabangResource::class;

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
