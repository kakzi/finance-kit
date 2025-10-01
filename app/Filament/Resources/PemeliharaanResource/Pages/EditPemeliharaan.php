<?php

namespace App\Filament\Resources\PemeliharaanResource\Pages;

use App\Filament\Resources\PemeliharaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPemeliharaan extends EditRecord
{
    protected static string $resource = PemeliharaanResource::class;

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
