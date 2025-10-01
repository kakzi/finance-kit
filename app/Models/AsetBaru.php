<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetBaru extends Model
{
    use HasFactory;

    protected $table = 'aset_barus';

    protected $fillable = [
        'user_id',
        'office_id',
        'date_permohonan',
        'nama_aset',
        'harga',
        'catatan',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Office
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
}
