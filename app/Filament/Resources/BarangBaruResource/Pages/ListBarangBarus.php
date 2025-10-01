<?php

namespace App\Filament\Resources\BarangBaruResource\Pages;

use App\Filament\Resources\BarangBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangBarus extends ListRecords
{
    protected static string $resource = BarangBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
