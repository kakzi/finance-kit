<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangReturn extends Model
{
    use HasFactory;

    protected $table = 'barang_returns';

    protected $fillable = [
        'office_from_id',
        'office_to_id',
        'nama_barang',
        'tanggal_kirim',
        'total',
    ];

    /**
     * Relasi ke Office asal
     */
    public function officeFrom()
    {
        return $this->belongsTo(Office::class, 'office_from_id');
    }

    /**
     * Relasi ke Office tujuan
     */
    public function officeTo()
    {
        return $this->belongsTo(Office::class, 'office_to_id');
    }
}
