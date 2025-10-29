<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'module',
        'module_id',
        'amount',
        'requested_by',
        'approval_by',
        'status',
        'note',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approval_by');
    }

    protected $casts = [
        'approval_by' => 'array',
    ];

    // public function getApprovalByAttribute()
    // {
    //     // Decode JSON atau array langsung
    //     $ids = is_array($this->approval_by) ? $this->approval_by : json_decode($this->approval_by, true);

    //     if (empty($ids)) {
    //         return [];
    //     }

    //     // Ambil nama user berdasarkan ID
    //     return User::whereIn('id', $ids)->pluck('name')->toArray();
    // }

}
