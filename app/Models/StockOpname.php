<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $table = 'stock_opnames';

    protected $fillable = [
        'office_id',
        'date_opname',
        'nomor_faktur',
        'total_selisih',
        'keterangan',
    ];

    /**
     * Relasi ke Office
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
}
