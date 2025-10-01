<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class LevelApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'jenis_transaksi',
        'level',
        'role_id',
        'limit_amount',
    ];

    /**
     * Relasi ke User (pemberi approval).
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
