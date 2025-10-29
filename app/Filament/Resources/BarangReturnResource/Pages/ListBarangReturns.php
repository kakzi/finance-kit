<?php

namespace App\Filament\Resources\BarangReturnResource\Pages;

use App\Filament\Resources\BarangReturnResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangReturns extends ListRecords
{
    protected static string $resource = BarangReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Return Barang'),
        ];
    }
}
