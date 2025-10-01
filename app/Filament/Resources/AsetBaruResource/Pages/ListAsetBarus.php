<?php

namespace App\Filament\Resources\AsetBaruResource\Pages;

use App\Filament\Resources\AsetBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsetBarus extends ListRecords
{
    protected static string $resource = AsetBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
