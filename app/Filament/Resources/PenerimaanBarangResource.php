<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PenerimaanBarang;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PenerimaanBarangResource\Pages;
use App\Filament\Resources\PenerimaanBarangResource\RelationManagers;

class PenerimaanBarangResource extends Resource
{
    protected static ?string $model = PenerimaanBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Penerimaan Barang';
    protected static ?string $navigationGroup = 'Pembelian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Informasi Penerimaan Barang Baru')
                    ->description('Detail Penerimaan barang masuk/baru')
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
                                'xl' => 6,
                                '2xl' => 6,
                            ])
                            ->required(),

                        // Forms\Components\DatePicker::make('tanggal_kirim')
                        //     ->label('Tanggal Kirim')
                        //     ->columnSpan([
                        //         'sm' => 2,
                        //         'xl' => 6,
                        //         '2xl' => 6,
                        //     ])
                        //     ->required(),

                        Forms\Components\TextInput::make('nomor_faktur')
                            ->label('Nomor Faktur')
                            // ->default(fn () => 'FINKIT-PENBAR-' . now()->format('Ymd') . '-' . str_pad(\App\Models\PenerimaanBarang::max('id') + 1, 4, '0', STR_PAD_LEFT))
                            // ->disabled()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 6,
                                '2xl' => 6,
                            ])
                            ->maxLength(191),

                        // Forms\Components\TextInput::make('number_transaction')
                        //     ->label('Nomor Transaksi')
                        //     ->default(fn () => 'FINKIT-ORDER-' . now()->format('Ymd') . '-' . str_pad(\App\Models\CashIn::max('id') + 1, 4, '0', STR_PAD_LEFT))
                        //     ->disabled()
                        //     ->required()
                        //     ->columnSpan([
                        //         'sm' => 2,
                        //         'xl' => 3,
                        //         '2xl' => 3,
                        //     ])
                        //     ->maxLength(191),

                        Forms\Components\Select::make('supplier_id')
                            ->label('Nama Supplier')
                            ->relationship('supplier', 'name')
                            ->native(false)
                            // ->searchable()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\Select::make('office_id')
                            ->label('Kantor Cabang')
                            ->relationship('office', 'name')
                            // ->searchable()
                            ->native(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\Select::make('method_payment')
                            ->label('Tipe')
                            ->options([
                                'cash' => 'Cash',
                                'credit' => 'Credit',
                                'penitipan' => 'Penitipan',
                            ])
                            ->native(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('total_pembelian')
                            ->label('Total Pembelian')
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
                Tables\Columns\TextColumn::make('supplier_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('office_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_faktur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('total_pembelian')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPenerimaanBarangs::route('/'),
            'create' => Pages\CreatePenerimaanBarang::route('/create'),
            'edit' => Pages\EditPenerimaanBarang::route('/{record}/edit'),
        ];
    }
}
