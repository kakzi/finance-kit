<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovalRequestResource\Pages;
use App\Models\ApprovalRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class ApprovalRequestResource extends Resource
{
    protected static ?string $model = ApprovalRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationGroup = 'Approval Management';
    protected static ?string $navigationLabel = 'Approval Requests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('module')->disabled(),
                // Forms\Components\TextInput::make('module_id')->disabled(),
                // Forms\Components\TextInput::make('amount')->disabled(),
                // Forms\Components\Select::make('approval_by')
                //     ->relationship('approver', 'name')
                //     ->disabled(),
                // Forms\Components\Textarea::make('note'),
                // Forms\Components\Select::make('status')
                //     ->options([
                //         'pending' => 'Pending',
                //         'approved' => 'Approved',
                //         'rejected' => 'Rejected',
                //     ])
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module')->sortable(),
                Tables\Columns\TextColumn::make('module_id'),
                Tables\Columns\TextColumn::make('amount')->money('idr', true),
                Tables\Columns\TextColumn::make('requester.name')->label('Requested By'),
                Tables\Columns\TextColumn::make('approver.name')->label('Approval By'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('updated_at')->since(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalRequests::route('/'),
            'create' => Pages\CreateApprovalRequest::route('/create'),
            'edit' => Pages\EditApprovalRequest::route('/{record}/edit'),
        ];
    }
}
