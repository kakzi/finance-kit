<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\CashIn;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ApprovalRequest;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TagsColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ApprovalRequestResource\Pages;

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
                Tables\Columns\TextColumn::make('note')->label('Keterangan')->sortable(),
                Tables\Columns\TextColumn::make('module')->label('Modul')->badge()->color('primary')->sortable(),
                // Tables\Columns\TextColumn::make('module_id'),
                Tables\Columns\TextColumn::make('amount')->money('idr', true),
                Tables\Columns\TextColumn::make('requester.name')->label('Requested By'),
                
                TagsColumn::make('approval_by')
                    ->label('Approval By')
                    ->getStateUsing(function ($record) {
                        // $record->approval_by berupa array ID
                        $ids = is_array($record->approval_by) ? $record->approval_by : json_decode($record->approval_by, true);

                        if (empty($ids)) {
                            return [];
                        }

                        // Ambil nama user berdasarkan ID
                        return User::whereIn('id', $ids)->pluck('name')->toArray();
                    })
                    ->separator("\n")  // <-- pakai newline
                    ->limit(50)  
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('updated_at')->label('Waktu')->since(),
            ])
            ->filters([])
            ->actions([
                    // ✅ ACTION: APPROVE
                    Action::make('approve')
                        ->label('Approve')
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->button()
                        ->visible(fn ($record) => $record->status === 'pending')
                        ->action(function ($record) {
                            // ✅ 1. Update status di tabel approvals
                            $record->update(['status' => 'approved']);

                            // ✅ 2. Tentukan model berdasarkan module
                            $moduleName = $record->module;

                            $modelMap = [
                                'order'          => \App\Models\Order::class,
                                'kas_masuk'          => \App\Models\CashIn::class,
                                'kas_keluar'         => \App\Models\CashOut::class,
                                'aset_baru'          => \App\Models\AsetBaru::class,
                                'aset_rusak'         => \App\Models\AsetRusak::class,
                                'barang_baru'        => \App\Models\BarangBaru::class,
                                'barang_return'      => \App\Models\BarangReturn::class,
                                'faktur_pembelian'   => \App\Models\FakturPembelian::class,
                                'mutasi_barang'      => \App\Models\MutasiBarang::class,
                                'pemeliharaan'       => \App\Models\Pemeliharaan::class,
                                'penerimaan_barang'  => \App\Models\PenerimaanBarang::class,
                                'pengiriman'         => \App\Models\Pengiriman::class,
                                'pesanan_cabang'     => \App\Models\PesananCabang::class,
                                'return_pembelian'   => \App\Models\ReturnPembelian::class,
                                'stock_opname'       => \App\Models\StockOpname::class,
                            ];

                            $modelClass = $modelMap[$moduleName] ?? null;
                            $moduleData = $modelClass ? $modelClass::find($record->module_id) : null;

                            if ($moduleData) {
                                $moduleData->update(['status' => 'approved']);
                            }

                            // ✅ 3. Notifikasi Filament UI
                            Notification::make()
                                ->title("Permintaan " . ucfirst(str_replace('_', ' ', $moduleName)) . " berhasil di-approve.")
                                ->success()
                                ->send();

                            // ✅ 4. Notifikasi WhatsApp ke user & grup
                            $requester = User::find($record->requested_by);
                            $apiKey   = '3440d8e1-d886-4f6f-b397-868d93a69f82';
                            $deviceId = '40c974f7-d4c2-45f0-9363-719b8309443c';
                            $groupId  = '120363422155163308@g.us';
                            $moduleLabel = ucfirst(str_replace('_', ' ', $moduleName));
                            $tanggal = now('Asia/Jakarta')->format('d M Y H:i');

                            $pesanUser = "✅ *Persetujuan {$moduleLabel}*\n\n"
                                . "Halo *{$requester->name}*,\n\n"
                                . "Permintaan {$moduleLabel} kamu telah *DISETUJUI* oleh *" . auth()->user()->name . "*.\n\n"
                                . "📅 Tanggal: {$tanggal}\n"
                                . "🔗 *Lihat detail:* " . url('approval-requests/' . $record->id);

                            $pesanGroup = "📢 *{$moduleLabel} DISETUJUI*\n\n"
                                . "Oleh: *" . auth()->user()->name . "*\n"
                                . "Pemohon: *{$requester->name}*\n"
                                . "📅 {$tanggal}\n"
                                . "🔗 " . url('approval-requests/' . $record->id);

                            // Kirim ke pemohon
                            if ($requester && !empty($requester->whatsapp)) {
                                Http::withHeaders([
                                    'x-api-key' => $apiKey,
                                    'Accept'    => 'application/json',
                                ])->post("https://www.beritahoe.com/api/devices/{$deviceId}/send-message", [
                                    'phone'   => $requester->whatsapp,
                                    'message' => $pesanUser,
                                ]);
                            }

                            // Kirim ke grup
                            Http::withHeaders([
                                'x-api-key' => $apiKey,
                                'Accept'    => 'application/json',
                            ])->post("https://www.beritahoe.com/api/devices/{$deviceId}/send-group-message", [
                                'groupId' => $groupId,
                                'message' => $pesanGroup,
                            ]);
                        }),

                    // ❌ ACTION: REJECT
                    Action::make('reject')
                        ->label('Reject')
                        ->color('danger')
                        ->icon('heroicon-o-x-circle')
                        ->requiresConfirmation()
                        ->button()
                        ->visible(fn ($record) => $record->status === 'pending')
                        ->action(function ($record) {
                            // 1️⃣ Update status di tabel approvals
                            $record->update(['status' => 'rejected']);

                            // 2️⃣ Tentukan model berdasarkan module
                            $moduleName = $record->module;
                            $modelMap = [
                                'order'          => \App\Models\Order::class,
                                'kas_masuk'          => \App\Models\CashIn::class,
                                'kas_keluar'         => \App\Models\CashOut::class,
                                'aset_baru'          => \App\Models\AsetBaru::class,
                                'aset_rusak'         => \App\Models\AsetRusak::class,
                                'barang_baru'        => \App\Models\BarangBaru::class,
                                'barang_return'      => \App\Models\BarangReturn::class,
                                'faktur_pembelian'   => \App\Models\FakturPembelian::class,
                                'mutasi_barang'      => \App\Models\MutasiBarang::class,
                                'pemeliharaan'       => \App\Models\Pemeliharaan::class,
                                'penerimaan_barang'  => \App\Models\PenerimaanBarang::class,
                                'pengiriman'         => \App\Models\Pengiriman::class,
                                'pesanan_cabang'     => \App\Models\PesananCabang::class,
                                'return_pembelian'   => \App\Models\ReturnPembelian::class,
                                'stock_opname'       => \App\Models\StockOpname::class,
                            ];

                            $modelClass = $modelMap[$moduleName] ?? null;
                            $moduleData = $modelClass ? $modelClass::find($record->module_id) : null;

                            if ($moduleData) {
                                $moduleData->update(['status' => 'rejected']);
                            }

                            // 3️⃣ Notifikasi Filament
                            Notification::make()
                                ->title("Permintaan " . ucfirst(str_replace('_', ' ', $moduleName)) . " telah ditolak.")
                                ->danger()
                                ->send();

                            // 4️⃣ WhatsApp Notification ke user & grup
                            $requester = User::find($record->requested_by);
                            $apiKey   = 'be930e7b-77d9-4b2f-9f2b-1a4820f0630d';
                            $deviceId = '4b476bf3-f84a-45e6-bc49-935dd49cc6f1';
                            $groupId  = '120363422155163308@g.us';
                            $moduleLabel = ucfirst(str_replace('_', ' ', $moduleName));
                            $tanggal = now('Asia/Jakarta')->format('d M Y H:i');

                            $pesanUser = "⚠️ *Penolakan {$moduleLabel}*\n\n"
                                . "Halo *{$requester->name}*,\n\n"
                                . "Permintaan {$moduleLabel} kamu telah *DITOLAK* oleh *" . auth()->user()->name . "*.\n\n"
                                . "📅 Tanggal: {$tanggal}\n"
                                . "🔗 *Lihat detail:* " . url('approval-requests/' . $record->id);

                            $pesanGroup = "📢 *{$moduleLabel} DITOLAK*\n\n"
                                . "Oleh: *" . auth()->user()->name . "*\n"
                                . "Pemohon: *{$requester->name}*\n"
                                . "📅 {$tanggal}\n"
                                . "🔗 " . url('approval-requests/' . $record->id);

                            // Kirim ke pemohon
                            if ($requester && !empty($requester->whatsapp)) {
                                Http::withHeaders([
                                    'x-api-key' => $apiKey,
                                    'Accept'    => 'application/json',
                                ])->post("https://www.beritahoe.com/api/devices/{$deviceId}/send-message", [
                                    'phone'   => $requester->whatsapp,
                                    'message' => $pesanUser,
                                ]);
                            }

                            // Kirim ke grup
                            Http::withHeaders([
                                'x-api-key' => $apiKey,
                                'Accept'    => 'application/json',
                            ])->post("https://www.beritahoe.com/api/devices/{$deviceId}/send-group-message", [
                                'groupId' => $groupId,
                                'message' => $pesanGroup,
                            ]);
                        }),

                // // ✅ ACTION: APPROVE
                // Action::make('approve')
                //     ->label('Approve')
                //     ->color('success')
                //     ->icon('heroicon-o-check-circle')
                //     ->requiresConfirmation()
                //     ->button()
                //     ->visible(fn ($record) => $record->status === 'pending')
                //     ->action(function ($record) {
                //         // ✅ 1. Update status di tabel approvals
                //         $record->update(['status' => 'approved']);

                //         // ✅ 2. Tentukan model berdasarkan module
                //         $moduleName = $record->module;

                //         $modelMap = [
                //             'kas_masuk'          => \App\Models\CashIn::class,
                //             'kas_keluar'         => \App\Models\CashOut::class,
                //             'aset_baru'          => \App\Models\AsetBaru::class,
                //             'aset_rusak'         => \App\Models\AsetRusak::class,
                //             'barang_baru'        => \App\Models\BarangBaru::class,
                //             'barang_return'      => \App\Models\BarangReturn::class,
                //             'faktur_pembelian'   => \App\Models\FakturPembelian::class,
                //             'mutasi_barang'      => \App\Models\MutasiBarang::class,
                //             'pemeliharaan'       => \App\Models\Pemeliharaan::class,
                //             'penerimaan_barang'  => \App\Models\PenerimaanBarang::class,
                //             'pengiriman'         => \App\Models\Pengiriman::class,
                //             'pesanan_cabang'     => \App\Models\PesananCabang::class,
                //             'return_pembelian'   => \App\Models\ReturnPembelian::class,
                //             'stock_opname'       => \App\Models\StockOpname::class,
                //         ];

                //         $modelClass = $modelMap[$moduleName] ?? null;
                //         $moduleData = $modelClass ? $modelClass::find($record->module_id) : null;

                //         if ($moduleData) {
                //             $moduleData->update(['status' => 'approved']);
                //         }

                //         // ✅ 3. Notifikasi Filament UI
                //         Notification::make()
                //             ->title("Permintaan " . ucfirst(str_replace('_', ' ', $moduleName)) . " berhasil di-approve.")
                //             ->success()
                //             ->send();

                //         // ✅ 4. Notifikasi WhatsApp
                //         $requester = User::find($record->requested_by);
                //         if ($requester && !empty($requester->whatsapp)) {
                //             $apiKey   = '3440d8e1-d886-4f6f-b397-868d93a69f82';
                //             $deviceId = '40c974f7-d4c2-45f0-9363-719b8309443c';
                //             $moduleLabel = ucfirst(str_replace('_', ' ', $moduleName));
                //             $tanggal = now('Asia/Jakarta')->format('d M Y H:i');

                //             $pesan = "✅ *Persetujuan {$moduleLabel}*\n\n"
                //                 . "Halo *{$requester->name}*,\n\n"
                //                 . "Permintaan {$moduleLabel} kamu telah *DISETUJUI* oleh *" . auth()->user()->name . "*.\n\n"
                //                 . "📅 Tanggal: {$tanggal}\n"
                //                 . "🔗 *Lihat detail:* " . url('approval-requests/' . $record->id);

                //             Http::withHeaders([
                //                 'x-api-key' => $apiKey,
                //                 'Accept'    => 'application/json',
                //             ])->post("https://www.beritahoe.com/api/devices/{$deviceId}/send-message", [
                //                 'phone'   => $requester->whatsapp,
                //                 'message' => $pesan,
                //             ]);
                //         }
                //     }),

                // // ❌ ACTION: REJECT
                // Action::make('reject')
                //     ->label('Reject')
                //     ->color('danger')
                //     ->icon('heroicon-o-x-circle')
                //     ->requiresConfirmation()
                //     ->button()
                //     ->visible(fn ($record) => $record->status === 'pending')
                //     ->action(function ($record) {
                //         // 1️⃣ Update status di tabel approvals
                //         $record->update(['status' => 'rejected']);

                //         // 2️⃣ Tentukan model berdasarkan module
                //         $moduleName = $record->module;
                //         $modelMap = [
                //             'kas_masuk'          => \App\Models\CashIn::class,
                //             'kas_keluar'         => \App\Models\CashOut::class,
                //             'aset_baru'          => \App\Models\AsetBaru::class,
                //             'aset_rusak'         => \App\Models\AsetRusak::class,
                //             'barang_baru'        => \App\Models\BarangBaru::class,
                //             'barang_return'      => \App\Models\BarangReturn::class,
                //             'faktur_pembelian'   => \App\Models\FakturPembelian::class,
                //             'mutasi_barang'      => \App\Models\MutasiBarang::class,
                //             'pemeliharaan'       => \App\Models\Pemeliharaan::class,
                //             'penerimaan_barang'  => \App\Models\PenerimaanBarang::class,
                //             'pengiriman'         => \App\Models\Pengiriman::class,
                //             'pesanan_cabang'     => \App\Models\PesananCabang::class,
                //             'return_pembelian'   => \App\Models\ReturnPembelian::class,
                //             'stock_opname'       => \App\Models\StockOpname::class,
                //         ];

                //         $modelClass = $modelMap[$moduleName] ?? null;
                //         $moduleData = $modelClass ? $modelClass::find($record->module_id) : null;

                //         if ($moduleData) {
                //             $moduleData->update(['status' => 'rejected']);
                //         }

                //         // 3️⃣ Notifikasi Filament
                //         Notification::make()
                //             ->title("Permintaan " . ucfirst(str_replace('_', ' ', $moduleName)) . " telah ditolak.")
                //             ->danger()
                //             ->send();

                //         // 4️⃣ WhatsApp Notification
                //         $requester = User::find($record->requested_by);
                //         if ($requester && !empty($requester->whatsapp)) {
                //             $apiKey   = 'be930e7b-77d9-4b2f-9f2b-1a4820f0630d';
                //             $deviceId = '4b476bf3-f84a-45e6-bc49-935dd49cc6f1';
                //             $moduleLabel = ucfirst(str_replace('_', ' ', $moduleName));
                //             $tanggal = now('Asia/Jakarta')->format('d M Y H:i');

                //             $pesan = "⚠️ *Penolakan {$moduleLabel}*\n\n"
                //                 . "Halo *{$requester->name}*,\n\n"
                //                 . "Permintaan {$moduleLabel} kamu telah *DITOLAK* oleh *" . auth()->user()->name . "*.\n\n"
                //                 . "📅 Tanggal: {$tanggal}\n"
                //                 . "🔗 *Lihat detail:* " . url('approval-requests/' . $record->id);

                //             Http::withHeaders([
                //                 'x-api-key' => $apiKey,
                //                 'Accept'    => 'application/json',
                //             ])->post("https://pintara.bmtnudigital.com/api/devices/{$deviceId}/send-message", [
                //                 'phone'   => $requester->whatsapp,
                //                 'message' => $pesan,
                //             ]);
                //         }
                //     }),

            ])
            ->modifyQueryUsing(function (Builder $query) {
                $userId = auth()->id();

                return $query
                    ->whereJsonContains('approval_by', $userId)
                    ->orderByDesc('created_at'); // urutkan dari terbaru ke terlama
            })

            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
