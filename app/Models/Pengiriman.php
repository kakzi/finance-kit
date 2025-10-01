<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimen'; // karena jamak-nya unik, kita tentukan manual

    protected $fillable = [
        'office_to_id',
        'transportasi_id',
        'tanggal_kirim',
        'nomor_faktur',
        'total',
        'driver_helper',
        'km_awal',
        'km_akhir',
        'bbm',
        'dokumentasi',
        'catatan',
    ];

    /**
     * Relasi ke Office tujuan
     */
    public function officeTo()
    {
        return $this->belongsTo(Office::class, 'office_to_id');
    }

    /**
     * Relasi ke Transportasi
     */
    public function transportasi()
    {
        return $this->belongsTo(Transportasi::class, 'transportasi_id');
    }
}