<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FakturPembelian extends Model
{
    use HasFactory;

    protected $table = 'faktur_pembelians';

    protected $fillable = [
        'supplier_id',
        'tanggal',
        'nomor_faktur',
        'total_pembelian',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_pembelian' => 'float',
    ];

    /**
     * Relasi ke Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relasi ke Office
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
