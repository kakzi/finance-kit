<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsetBaruResource\Pages;
use App\Models\AsetBaru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Support\RawJs;

class AsetBaruResource extends Resource
{
    protected static ?string $model = AsetBaru::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Aset';

    protected static ?string $navigationLabel = 'Aset Baru';

    protected static ?string $pluralLabel = 'Aset Baru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Aset Baru')
                    ->description('Data permohonan pengadaan aset baru.')
                    ->icon('heroicon-m-cube')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([

                        Forms\Components\Select::make('user_id')
                            ->label('Diajukan Oleh')
                            ->relationship('user', 'name')
                            ->default(auth()->id()) // otomatis isi user login
                            ->disabled() // supaya tidak bisa diganti
                            ->dehydrated() // tetap tersimpan di database
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),


                        Forms\Components\Select::make('office_id')
                            ->label('Cabang')
                            ->relationship('office', 'name')
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\DatePicker::make('date_permohonan')
                            ->label('Tanggal Permohonan')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\TextInput::make('nama_aset')
                            ->label('Nama Aset')
                            ->required()
                            ->maxLength(191)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 6,
                                '2xl' => 6,
                            ]),

                        Forms\Components\TextInput::make('harga')
                            ->label('Harga Aset')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
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
                                'xl' => 12,
                                '2xl' => 12,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Diajukan Oleh')->searchable(),
                Tables\Columns\TextColumn::make('office.name')->label('Cabang')->searchable(),
                Tables\Columns\TextColumn::make('date_permohonan')->label('Tanggal')->date(),
                Tables\Columns\TextColumn::make('nama_aset')->label('Nama Aset')->searchable(),
                Tables\Columns\TextColumn::make('harga')->label('Harga')->money('idr'),
                Tables\Columns\TextColumn::make('created_at')->label('Diajukan Pada')->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('office_id')
                    ->label('Filter Cabang')
                    ->relationship('office', 'name'),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Filter Pengaju')
                    ->relationship('user', 'name'),

                Tables\Filters\Filter::make('date_permohonan')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('date_permohonan', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('date_permohonan', '<=', $data['until']));
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsetBarus::route('/'),
            'create' => Pages\CreateAsetBaru::route('/create'),
            'edit' => Pages\EditAsetBaru::route('/{record}/edit'),
        ];
    }
}
