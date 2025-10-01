<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangReturnResource\Pages;
use App\Models\BarangReturn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Support\RawJs;

class BarangReturnResource extends Resource
{
    protected static ?string $model = BarangReturn::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static ?string $navigationGroup = 'Persediaan';

    protected static ?string $navigationLabel = 'Barang Return';

    protected static ?string $pluralLabel = 'Barang Return';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Barang Return')
                    ->description('Data barang yang diretur, cabang asal & tujuan.')
                    ->icon('heroicon-m-arrow-uturn-left')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([

                        Forms\Components\Select::make('office_from_id')
                            ->label('Dari Cabang')
                            ->relationship('officeFrom', 'name')
                            ->native(false)
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\Select::make('office_to_id')
                            ->label('Ke Cabang')
                            ->relationship('officeTo', 'name')
                            ->native(false)
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->required()
                            ->maxLength(191)
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

                        Forms\Components\TextInput::make('total')
                            ->label('Total Barang')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('officeFrom.name')->label('Cabang Asal')->searchable(),
                Tables\Columns\TextColumn::make('officeTo.name')->label('Cabang Tujuan')->searchable(),
                Tables\Columns\TextColumn::make('nama_barang')->label('Nama Barang')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kirim')->label('Tanggal Kirim')->date(),
                Tables\Columns\TextColumn::make('total')->label('Total')->money('idr'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dibuat'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('office_from_id')
                    ->label('Filter Cabang Asal')
                    ->relationship('officeFrom', 'name'),

                Tables\Filters\SelectFilter::make('office_to_id')
                    ->label('Filter Cabang Tujuan')
                    ->relationship('officeTo', 'name'),

                Tables\Filters\Filter::make('tanggal_kirim')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('tanggal_kirim', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('tanggal_kirim', '<=', $data['until']));
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangReturns::route('/'),
            'create' => Pages\CreateBarangReturn::route('/create'),
            'edit' => Pages\EditBarangReturn::route('/{record}/edit'),
        ];
    }
}
