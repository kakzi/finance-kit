<?php

namespace App\Filament\Resources\AsetRusakResource\Pages;

use App\Filament\Resources\AsetRusakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsetRusaks extends ListRecords
{
    protected static string $resource = AsetRusakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
