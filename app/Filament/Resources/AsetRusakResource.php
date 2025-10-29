<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsetRusakResource\Pages;
use App\Models\AsetRusak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class AsetRusakResource extends Resource
{
    protected static ?string $model = AsetRusak::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationLabel = 'Aset Rusak';
    protected static ?string $navigationGroup = 'Aset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Aset Rusak')
                    ->description('Detail permohonan laporan aset rusak.')
                    ->icon('heroicon-m-exclamation-triangle')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Diajukan Oleh')
                            ->relationship('user', 'name')
                            ->default(auth()->id())
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ])
                            ->required(),

                        Forms\Components\Select::make('office_id')
                            ->label('Cabang')
                            ->relationship('office', 'name')
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                        Forms\Components\DatePicker::make('date_permohonan')
                            ->label('Tanggal Permohonan')
                            ->required()
                            ->default(now())
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                        Forms\Components\TextInput::make('nama_aset')
                            ->label('Nama Aset')
                            ->required()
                            ->maxLength(191)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->required()
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
                Tables\Columns\TextColumn::make('user.name')->label('Diajukan Oleh')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('office.name')->label('Cabang')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('date_permohonan')->label('Tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('nama_aset')->label('Nama Aset')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('catatan')->label('Catatan')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat Pada')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Diperbarui Pada')->dateTime()->toggleable(isToggledHiddenByDefault: true),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsetRusaks::route('/'),
            'create' => Pages\CreateAsetRusak::route('/create'),
            'edit' => Pages\EditAsetRusak::route('/{record}/edit'),
        ];
    }
}
