<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'supplier_id',
        'office_id',
        'tanggal_order',
        'tanggal_kirim',
        'nomor_faktur',
        'number_transaction',
        'method_payment',
        'total_perkiraan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_order' => 'date',
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
