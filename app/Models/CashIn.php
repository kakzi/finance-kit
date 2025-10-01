<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id', 'user_id', 'category_id', 'tanggal', 'nomor_faktur', 'total', 'keterangan', 'catatan', 'status','number_transaction'
    ];


    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function approvals()
    // {
    //     return $this->morphMany(Approval::class, 'modul');
    // }
}
