<?php

namespace App\Filament\Resources\AsetBaruResource\Pages;

use App\Filament\Resources\AsetBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsetBaru extends EditRecord
{
    protected static string $resource = AsetBaruResource::class;

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
