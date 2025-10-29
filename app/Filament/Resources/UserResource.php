<?php

namespace App\Filament\Resources;

use Hash;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\UserResource\Pages;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Filament\Infolists\Components\Section as InfolistSection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->description('Fill in the basic information for the user.')
                    ->icon('heroicon-o-user')
                    ->columns([
                        'sm' => 2,
                        'lg' => 8,
                        '2xl' => 6,
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpan(2),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp Number')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('e.g. 6281234567890')
                            ->columnSpan(2),

                        Select::make('role_id')
                            ->label('Role')
                            ->relationship('role', 'name')
                            ->searchable()
                            ->required()
                            ->columnSpan(2),

                        Select::make('office_id')
                            ->label('Office')
                            ->relationship('office', 'name')
                            ->searchable()
                            ->required()
                            ->columnSpan(2),

                        Select::make('level_approval_id')
                            ->label('Level Approval')
                            ->options(function () {
                                return \App\Models\LevelApproval::all()
                                    ->mapWithKeys(fn ($item) => [
                                        $item->id => "{$item->level} - Rp " . number_format($item->limit_amount, 0, ',', '.')
                                    ]);
                            })
                            ->searchable()
                            ->required()
                            ->columnSpan(2),


                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->minLength(8)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)) // hanya disimpan jika ada isinya
                            ->columnSpan(2),
                    ]),

            ]);
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('avatar_url')
                        ->searchable()
                        ->circular()
                        ->grow(false)
                        ->getStateUsing(fn($record) => $record->avatar_url
                            ? $record->avatar_url
                            : "https://ui-avatars.com/api/?name=" . urlencode($record->name)),
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()
                        ->weight(FontWeight::Bold),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('roles.name')
                            ->searchable()
                            ->icon('heroicon-o-shield-check')
                            ->grow(false),
                        Tables\Columns\TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->searchable()
                            ->grow(false),
                    ])->alignStart()->visibleFrom('lg')->space(1)
                ]),
            ])
            ->filters([
                //
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button(),
                Action::make('Set Role')
                    ->icon('heroicon-m-adjustments-vertical')
                    ->button()
                    ->color('success')
                    ->form([
                        Select::make('role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->optionsLimit(10)
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->name),
                    ]),
                // Impersonate::make(),
                Tables\Actions\DeleteAction::make()->button(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(UserExporter::class),
                ImportAction::make()
                    ->importer(UserImporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
                    ->exporter(UserExporter::class)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make('User Information')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email'),
                ]),
            ]);
    }
}
