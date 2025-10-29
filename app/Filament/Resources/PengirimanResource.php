<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengirimanResource\Pages;
use App\Models\Pengiriman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Support\RawJs;

class PengirimanResource extends Resource
{
    protected static ?string $model = Pengiriman::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Persediaan';
    protected static ?string $navigationLabel = 'Pengiriman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengiriman Barang')
                    ->description('Detail tanggal, nomor faktur, transportasi, dan cabang tujuan.')
                    ->icon('heroicon-m-truck')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('nomor_faktur')
                            ->label('Nomor Faktur')
                            ->maxLength(191)
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\DatePicker::make('tanggal_kirim')
                            ->label('Tanggal Kirim')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\Select::make('office_to_id')
                            ->label('Tujuan Cabang')
                            ->relationship('officeTo', 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\Select::make('transportasi_id')
                            ->label('Transportasi')
                            ->relationship('transportasi', 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Kendaraan')
                                    ->required(),
                            ])
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\TextInput::make('total')
                            ->label('Total Pengiriman')
                            ->numeric()
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\TextInput::make('driver_helper')
                            ->label('Nama Driver & Helper')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\TextInput::make('km_awal')
                            ->label('KM Awal')
                            ->required()
                            ->numeric()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\TextInput::make('km_akhir')
                            ->label('KM Akhir')
                            ->required()
                            ->numeric()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\Toggle::make('bbm')
                            ->label('Apakah BBM Ditanggung?')
                            ->default(false)
                            ->inline(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 2,
                                '2xl' => 2,
                            ]),

                        Forms\Components\FileUpload::make('dokumentasi')
                            ->label('Upload Dokumentasi')
                            ->directory('pengiriman/dokumentasi')
                            ->image()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 6,
                                '2xl' => 6,
                            ]),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan Tambahan')
                            ->rows(4)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 6,
                                '2xl' => 6,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_faktur')->label('Nomor Faktur')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kirim')->label('Tanggal Kirim')->date(),
                Tables\Columns\TextColumn::make('officeTo.name')->label('Cabang Tujuan')->searchable(),
                Tables\Columns\TextColumn::make('transportasi.name')->label('Transportasi'),
                Tables\Columns\TextColumn::make('driver_helper')->label('Driver & Helper'),
                Tables\Columns\IconColumn::make('bbm')->label('BBM')->boolean(),
                Tables\Columns\TextColumn::make('total')->label('Total')->money('idr'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengirimen::route('/'),
            'create' => Pages\CreatePengiriman::route('/create'),
            'edit' => Pages\EditPengiriman::route('/{record}/edit'),
        ];
    }
}