<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FakturPembelian;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FakturPembelianResource\Pages;
use App\Filament\Resources\FakturPembelianResource\RelationManagers;

class FakturPembelianResource extends Resource
{
    protected static ?string $model = FakturPembelian::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Faktur Pembelian';
    protected static ?string $navigationGroup = 'Pembelian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Faktur Pembelian')
                    ->description('Detail Faktur Pembelian')
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
                            // ->default(fn () => 'FINKIT-PENBAR-' . now()->format('Ymd') . '-' . str_pad(\App\Models\FakturPembelian::max('id') + 1, 4, '0', STR_PAD_LEFT))
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
                            // ->searchable()
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
                Tables\Columns\TextColumn::make('supplier.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_faktur')
                    ->searchable(),
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
            'index' => Pages\ListFakturPembelians::route('/'),
            'create' => Pages\CreateFakturPembelian::route('/create'),
            'edit' => Pages\EditFakturPembelian::route('/{record}/edit'),
        ];
    }
}
