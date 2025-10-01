<?php

namespace App\Filament\Resources\BarangReturnResource\Pages;

use App\Filament\Resources\BarangReturnResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangReturn extends EditRecord
{
    protected static string $resource = BarangReturnResource::class;

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
