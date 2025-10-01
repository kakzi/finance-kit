<?php

namespace App\Filament\Resources\CashInResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use App\Filament\Resources\CashInResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCashIn extends CreateRecord
{
    protected static string $resource = CashInResource::class;
    protected static bool $canCreateAnother = false;


    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // custom label tombol create
    // protected function getCreateFormAction(): CreateAction
    // {
    //     return parent::getCreateFormAction()
    //         ->label('Kirim Persetujuan'); // ubah label tombol
    // }
    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Kirim Persetujuan')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }
}
