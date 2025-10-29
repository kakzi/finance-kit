<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelApprovalResource\Pages;
use App\Models\LevelApproval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Spatie\Permission\Models\Role;

class LevelApprovalResource extends Resource
{
    protected static ?string $model = LevelApproval::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationLabel = 'Level Approval';
    protected static ?string $navigationGroup = 'Approval Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Level Approval')
                    ->description('Atur level approval berdasarkan kategori, transaksi, dan batas nominal.')
                    ->icon('heroicon-m-check-badge')
                    ->columns([
                        'sm' => 2,
                        'xl' => 6,
                        '2xl' => 12,
                    ])
                    ->schema([

                        Forms\Components\TextInput::make('kategori')
                            ->label('Kategori')
                            ->placeholder('Contoh: Keuangan, Pembelian, Persediaan')
                            ->required()
                            ->maxLength(191)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 6,
                                '2xl' => 6,
                            ]),

                        Forms\Components\TextInput::make('jenis_transaksi')
                            ->label('Jenis Transaksi')
                            ->placeholder('Contoh: Pesanan, Pengiriman, Mutasi Barang')
                            ->required()
                            ->maxLength(191)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 6,
                                '2xl' => 6,
                            ]),

                        Forms\Components\Select::make('level')
                            ->label('Level Approval')
                            ->options([
                                'L0' => 'Level 0',
                                'L1' => 'Level 1',
                                'L2' => 'Level 2',
                                'L3' => 'Level 3',
                                'L4' => 'Level 4',
                                'L5' => 'Level 5',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Forms\Components\Select::make('role_id')
                            ->label('Role Approver')
                            ->options(Role::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),


                        Forms\Components\TextInput::make('limit_amount')
                            ->label('Batas Nominal')
                            ->numeric()
                            ->prefix('Rp')
                            ->mask(\Filament\Support\RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->required()
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
                Tables\Columns\TextColumn::make('kategori')->label('Kategori')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('jenis_transaksi')->label('Jenis Transaksi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('level')->label('Level')->sortable(),
                Tables\Columns\TextColumn::make('role.name')->label('Role Approver'),
                Tables\Columns\TextColumn::make('limit_amount')->label('Batas Nominal')->money('IDR')->sortable(),
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
            'index' => Pages\ListLevelApprovals::route('/'),
            'create' => Pages\CreateLevelApproval::route('/create'),
            'edit' => Pages\EditLevelApproval::route('/{record}/edit'),
        ];
    }
}
