<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\BarangBaru;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangBaruResource\Pages;
use App\Filament\Resources\BarangBaruResource\RelationManagers;

class BarangBaruResource extends Resource
{
    protected static ?string $model = BarangBaru::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Barang Baru';
    protected static ?string $navigationGroup = 'Pembelian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Informasi Barang Baru')
                    ->description('Detail barang masuk/baru')
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

                        Forms\Components\DatePicker::make('tanggal_kirim')
                            ->label('Tanggal Kirim')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 6,
                                '2xl' => 6,
                            ])
                            ->required(),


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
                            ->label('Kirim ke Cabang')
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
                Tables\Columns\TextColumn::make('supplier.name')->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('office.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_kirim')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method_payment')->badge()->color('primary'),
                Tables\Columns\TextColumn::make('total_perkiraan')
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
            'index' => Pages\ListBarangBarus::route('/'),
            'create' => Pages\CreateBarangBaru::route('/create'),
            'edit' => Pages\EditBarangBaru::route('/{record}/edit'),
        ];
    }
}
