<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnPembelian extends Model
{
    use HasFactory;

    protected $table = 'return_pembelians';

    protected $fillable = [
        'supplier_id',
        'tanggal',
        'nomor_faktur',
        'total_return_pembelian',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_return_pembelian' => 'float',
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
