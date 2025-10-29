<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Order';
    protected static ?string $navigationGroup = 'Pembelian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Order')
                    ->description('Detail tanggal & nomor transaksi order.')
                    ->icon('heroicon-m-shopping-bag')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_order')
                            ->label('Tanggal Order')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ])
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_kirim')
                            ->label('Tanggal Kirim')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('nomor_faktur')
                            ->label('Nomor Pesanan')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
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
                            ->searchable()
                            ->preload()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\Select::make('office_id')
                            ->label('Kirim ke Cabang')
                            ->relationship('office', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\Select::make('method_payment')
                            ->label('Metode Pembayaran')
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

                        Forms\Components\TextInput::make('total_perkiraan')
                            ->label('Total Perkiraan')
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
                Tables\Columns\TextColumn::make('nomor_faktur')
                    ->label('Nomor Faktur')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('office.name')
                    ->label('Office')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_order')
                    ->label('Tanggal Order')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_kirim')
                    ->label('Tanggal Kirim')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('method_payment')
                    ->label('Pembayaran')
                    ->badge(),

                Tables\Columns\TextColumn::make('total_perkiraan')
                    ->label('Total Perkiraan')
                    ->money('IDR', true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // bisa ditambahkan RelationManager kalau ada order_items
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
