<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\CashOut;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CashOutResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CashOutResource\RelationManagers;

class CashOutResource extends Resource
{
    protected static ?string $model = CashOut::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Kas Keluar';
    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kas Keluar')
                    ->description('Buat Persetujuan untuk Kas Keluar')
                    ->icon('heroicon-m-shopping-bag')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('number_transaction')
                            ->label('Nomor Transaksi')
                            ->default(fn () => 'FINKIT-CASHOUT-' . now()->format('Ymd') . '-' . str_pad(\App\Models\CashIn::max('id') + 1, 4, '0', STR_PAD_LEFT))
                            ->disabled() // biar tidak bisa diubah user
                            ->dehydrated()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 6,
                            ]), // tetap tersimpan ke database

                        Forms\Components\TextInput::make('nomor_faktur')
                            ->label('Nomor Faktur')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 6,
                            ]), // tetap tersimpan ke database
                        
                        Forms\Components\Select::make('office_id')
                            ->relationship('office', 'name')
                            ->label('Kantor Cabang')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 4,
                            ]),

                        Forms\Components\hidden::make('user_id')
                            // ->relationship('user', 'name')
                            ->label('Dibuat Oleh')
                            ->default(auth()->id()) // otomatis terisi user login
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 4,
                            ]),

                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->native(false)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Akun Keuangan')
                                    ->required(),
                            ])
                            ->label('Akun Keuangan')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 4,
                            ]),

                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required()
                            ->default(Carbon::now()->toDateString())
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 4,
                            ]),
                        TextInput::make('total_sebelum_potongan')
                            ->label('Total Sebelum Potongan')
                            ->numeric()
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $set('dibayarkan', (int) str_replace(',', '', $get('total_sebelum_potongan') ?? 0) - (int) str_replace(',', '', $get('total_potongan') ?? 0) );
                            })
                            ->columnSpan(['sm' => 2, 'xl' => 3, '2xl' => 4]),

                        TextInput::make('total_potongan')
                            ->label('Total Potongan')
                            ->numeric()
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $set('dibayarkan', (int) str_replace(',', '', $get('total_sebelum_potongan') ?? 0) - (int) str_replace(',', '', $get('total_potongan') ?? 0) );
                            })
                            ->columnSpan(['sm' => 2, 'xl' => 3, '2xl' => 4]),

                        TextInput::make('dibayarkan')
                            ->label('Total Yang Dibayarkan')
                            ->disabled()
                            ->dehydrated()
                            ->prefix('Rp')
                            ->numeric()
                            ->columnSpan(['sm' => 2, 'xl' => 3, '2xl' => 4]),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 6,
                            ]),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 6,
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //  Tables\Columns\TextColumn::make('nomor_faktur')
                //     ->label('Nomor Faktur')
                //     ->sortable()
                //     ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Uraian')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('office.name')
                    ->label('Kantor')
                    ->sortable()
                    ->searchable(),

                // Tables\Columns\TextColumn::make('user.name')
                //     ->label('User')
                //     ->sortable()
                //     ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),


                Tables\Columns\TextColumn::make('dibayarkan')
                    ->label('Total')
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'info' => 'draft',
                        'warning'   => 'pending',
                        'success'   => 'approved',
                        'danger'    => 'rejected',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),

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
            'index' => Pages\ListCashOuts::route('/'),
            'create' => Pages\CreateCashOut::route('/create'),
            'edit' => Pages\EditCashOut::route('/{record}/edit'),
        ];
    }
}
