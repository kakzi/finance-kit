<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangBaru extends Model
{
    use HasFactory;

    protected $table = 'barang_barus';

    protected $fillable = [
        'supplier_id',
        'office_id',
        'tanggal',
        'tanggal_kirim',
        'method_payment',
        'total_perkiraan',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_kirim' => 'date',
        'total_perkiraan' => 'float',
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
