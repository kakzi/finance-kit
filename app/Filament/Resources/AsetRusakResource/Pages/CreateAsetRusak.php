<?php

namespace App\Filament\Resources\AsetRusakResource\Pages;

use App\Filament\Resources\AsetRusakResource;
use Log;
use App\Models\User;
use Filament\Actions\Action;
use App\Models\LevelApproval;
use App\Models\ApprovalRequest;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Http;
use Filament\Resources\Pages\CreateRecord;

class CreateAsetRusak extends CreateRecord
{
    protected static string $resource = AsetRusakResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Kirim Persetujuan')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }


    protected function afterCreate(): void
    {
        $cashIn = $this->record;

        // 1️⃣ Ambil semua level approval yang limit >= total dan bukan L0
        $levels = LevelApproval::where('level', '!=', 'L0')
            ->get();
        // dd($levels);
        if (! $levels) {
            // Jika tidak ada level yang sesuai, tidak perlu approval
            return;
        }

        // 2️⃣ Kumpulkan semua approver dari semua level
        $approvers = User::whereIn('level_approval_id', $levels->pluck('id'))
        // ->where('office_id', $cashIn->office_id) // aktifkan jika ingin filter per kantor
        ->pluck('id')
        ->toArray();     
        // dd($approvers); 

        // 3️⃣ Simpan approval request (menyimpan semua approver dalam array JSON)
        $approvalRequest = ApprovalRequest::create([
            'module'        => 'aset_rusak',
            'module_id'     => $cashIn->id,
            'amount'        => 0,
            'requested_by'  => auth()->id(),
            'approval_by'   => $approvers,
            'status'        => 'pending',
            'note'          => 'Permintaan Persetujuan Aset Rusak',
        ]);

         // 4️⃣ Kirim notifikasi WhatsApp ke semua approver
        $apiKey   = '3440d8e1-d886-4f6f-b397-868d93a69f82';
        $deviceId = '40c974f7-d4c2-45f0-9363-719b8309443c';

        foreach ($approvers as $approverId) {
            $approver = \App\Models\User::find($approverId);

            if (!$approver || empty($approver->whatsapp)) {
                continue;
            }

            $pesan = 
                "📩 *Permintaan Persetujuan Baru*\n\n" .
                "🧾 Modul: *Aset Rusak*\n" .
                "💰 Aset: " . $cashIn->nama_aset. "\n" .
                "🏢 Kantor: *" . $cashIn->office->name . "*\n" .
                "👤 Diajukan oleh: *" . auth()->user()->name . "*\n\n" .
                "Mohon ditinjau melalui sistem approval.\n\n" .
                "🔗 *Kunjungi:* " . url('approval-requests/' . $approvalRequest->id);

            Http::withHeaders([
                'x-api-key' => $apiKey,
                'Accept'    => 'application/json',
            ])->post("https://www.beritahoe.com/api/devices/{$deviceId}/send-message", [
                'phone'   => $approver->whatsapp,
                'message' => $pesan,
            ]);
        }
    }
}
