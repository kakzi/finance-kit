<?php

namespace App\Filament\Resources\AsetBaruResource\Pages;

use App\Filament\Resources\AsetBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAsetBaru extends CreateRecord
{
    protected static string $resource = AsetBaruResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
