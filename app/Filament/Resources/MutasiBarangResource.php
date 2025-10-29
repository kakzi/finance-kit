<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MutasiBarang;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MutasiBarangResource\Pages;
use App\Filament\Resources\MutasiBarangResource\RelationManagers;

class MutasiBarangResource extends Resource
{
    protected static ?string $model = MutasiBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Mutasi Barang';
    protected static ?string $navigationGroup = 'Persediaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Mutasi Barang')
                    ->description('Detail tanggal & nomor transaksi Mutasi Barang.')
                    ->icon('heroicon-m-shopping-bag')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([

                        Forms\Components\TextInput::make('nomor_faktur')
                            ->label('Nomor Faktur')
                            // ->default(fn () => 'FINKIT-ORDER-' . now()->format('Ymd') . '-' . str_pad(\App\Models\MutasiBarang::max('id') + 1, 4, '0', STR_PAD_LEFT))
                            // ->disabled()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->maxLength(191),
                        Forms\Components\DatePicker::make('tanggal_mutasi')
                            ->label('Tanggal Mutasi')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_kirim')
                            ->label('Tanggal Kirim')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                      

                        Forms\Components\Select::make('office_from_id')
                            ->label('Dari Cabang Mana')
                            ->relationship('officeFrom', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),
                        Forms\Components\Select::make('office_to_id')
                            ->label('Ke Cabang Mana')
                            ->relationship('officeTo', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),
                        Forms\Components\Select::make('transportasi_id')
                            ->label('Transportasi')
                            ->relationship('transportasi', 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')->label('Nama Kendaraan')
                                    ->required(),
                            ])
                            // ->searchable()
                            ->native(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),

                        

                        Forms\Components\TextInput::make('total_mutasi')
                            ->label('Total Mutasi')
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
                        Forms\Components\TextInput::make('driver_helper')
                            ->label('Nama Driver & Helper')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('checker')
                            ->label('Nama Checker')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('recipient')
                            ->label('Nama Penerima')
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
                Tables\Columns\TextColumn::make('officeFrom.name')->label('Dari Cabang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('officeTo.name')->label('Ke Cabang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transportasi.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mutasi')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_kirim')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_mutasi')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListMutasiBarangs::route('/'),
            'create' => Pages\CreateMutasiBarang::route('/create'),
            'edit' => Pages\EditMutasiBarang::route('/{record}/edit'),
        ];
    }
}
