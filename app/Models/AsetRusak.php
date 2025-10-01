<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetRusak extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_id',
        'date_permohonan',
        'nama_aset',
        'catatan',
    ];

    /**
     * Relasi ke User (pengaju aset rusak).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Office (cabang pengaju).
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
