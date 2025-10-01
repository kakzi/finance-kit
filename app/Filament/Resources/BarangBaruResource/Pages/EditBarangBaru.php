<?php

namespace App\Filament\Resources\BarangBaruResource\Pages;

use App\Filament\Resources\BarangBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangBaru extends EditRecord
{
    protected static string $resource = BarangBaruResource::class;

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
