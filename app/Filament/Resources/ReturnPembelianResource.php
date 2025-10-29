<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ReturnPembelian;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReturnPembelianResource\Pages;
use App\Filament\Resources\ReturnPembelianResource\RelationManagers;

class ReturnPembelianResource extends Resource
{
    protected static ?string $model = ReturnPembelian::class;
    protected static ?string $navigationGroup = 'Pembelian';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = ' Return Pembelian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Return Pembelian')
                    ->description('Detail Return Pembelian')
                    ->icon('heroicon-m-shopping-bag')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('nomor_faktur')
                            ->label('Nomor Faktur')
                            // ->default(fn () => 'FINKIT-RETPEM-' . now()->format('Ymd') . '-' . str_pad(\App\Models\ReturnPembelian::max('id') + 1, 4, '0', STR_PAD_LEFT))
                            // ->disabled()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->maxLength(191),


                        Forms\Components\Select::make('supplier_id')
                            ->label('Nama Supplier')
                            ->relationship('supplier', 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('total_return_pembelian')
                            ->label('Total Return Pembelian')
                            ->numeric()
                            ->prefix('Rp')
                            ->mask(\Filament\Support\RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 8,
                                '2xl' => 8,
                            ])
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
   Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReturnPembelians::route('/'),
            'create' => Pages\CreateReturnPembelian::route('/create'),
            'edit' => Pages\EditReturnPembelian::route('/{record}/edit'),
        ];
    }
}
