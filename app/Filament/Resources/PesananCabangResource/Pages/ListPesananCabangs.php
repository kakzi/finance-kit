<?php

namespace App\Filament\Resources\PesananCabangResource\Pages;

use App\Filament\Resources\PesananCabangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesananCabangs extends ListRecords
{
    protected static string $resource = PesananCabangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Pesanan Cabang'),
        ];
    }
}
