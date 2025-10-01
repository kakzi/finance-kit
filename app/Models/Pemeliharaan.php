<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
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
     * Relasi ke User (pengaju pemeliharaan).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Office (cabang).
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
