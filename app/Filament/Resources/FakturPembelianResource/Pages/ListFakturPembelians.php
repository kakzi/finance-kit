<?php

namespace App\Filament\Resources\FakturPembelianResource\Pages;

use App\Filament\Resources\FakturPembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFakturPembelians extends ListRecords
{
    protected static string $resource = FakturPembelianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Faktur Pembelian'),
        ];
    }
}
