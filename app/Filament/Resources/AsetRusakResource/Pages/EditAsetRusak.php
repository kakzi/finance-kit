<?php

namespace App\Filament\Resources\AsetRusakResource\Pages;

use App\Filament\Resources\AsetRusakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsetRusak extends EditRecord
{
    protected static string $resource = AsetRusakResource::class;

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
