<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_from_id',
        'office_to_id',
        'transportasi_id',
        'tanggal_mutasi',
        'tanggal_kirim',
        'nomor_faktur',
        'total_mutasi',
        'checker',
        'driver_helper',
        'recipient',
        'catatan',
    ];

    // Relasi ke Office (asal mutasi)
    public function officeFrom()
    {
        return $this->belongsTo(Office::class, 'office_from_id');
    }

    // Relasi ke Office (tujuan mutasi)
    public function officeTo()
    {
        return $this->belongsTo(Office::class, 'office_to_id');
    }

    // Relasi ke Transportasi
    public function transportasi()
    {
        return $this->belongsTo(Transportasi::class, 'transportasi_id');
    }
}
