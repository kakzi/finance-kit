<?php

namespace App\Filament\Resources\PemeliharaanResource\Pages;

use App\Filament\Resources\PemeliharaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPemeliharaans extends ListRecords
{
    protected static string $resource = PemeliharaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Pemeliharaan Baru'),
        ];
    }
}
