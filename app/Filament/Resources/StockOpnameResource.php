<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockOpnameResource\Pages;
use App\Models\StockOpname;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Support\RawJs;

class StockOpnameResource extends Resource
{
    protected static ?string $model = StockOpname::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Persediaan';

    protected static ?string $navigationLabel = 'Stock Opname';

    protected static ?string $pluralLabel = 'Stock Opname';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Stock Opname')
                    ->description('Data opname stok, cabang, selisih, dan keterangan.')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([

                        Forms\Components\Select::make('office_id')
                            ->label('Kantor Cabang')
                            ->relationship('office', 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                        Forms\Components\DatePicker::make('date_opname')
                            ->label('Tanggal Opname')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                        Forms\Components\TextInput::make('nomor_faktur')
                            ->label('Nomor Faktur')
                            ->required()
                            ->maxLength(191)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                        Forms\Components\TextInput::make('total_selisih')
                            ->label('Total Selisih')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
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
                Tables\Columns\TextColumn::make('office.name')->label('Cabang')->searchable(),
                Tables\Columns\TextColumn::make('date_opname')->label('Tanggal Opname')->date(),
                Tables\Columns\TextColumn::make('nomor_faktur')->label('Nomor Faktur')->searchable(),
                Tables\Columns\TextColumn::make('total_selisih')->label('Total Selisih')->money('idr'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat Pada')->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('office_id')
                    ->label('Filter Cabang')
                    ->relationship('office', 'name'),

                Tables\Filters\Filter::make('date_opname')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('date_opname', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('date_opname', '<=', $data['until']));
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockOpnames::route('/'),
            'create' => Pages\CreateStockOpname::route('/create'),
            'edit' => Pages\EditStockOpname::route('/{record}/edit'),
        ];
    }
}
