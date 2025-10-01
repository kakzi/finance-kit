<?php

namespace App\Filament\Resources\AsetRusakResource\Pages;

use App\Filament\Resources\AsetRusakResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAsetRusak extends CreateRecord
{
    protected static string $resource = AsetRusakResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
