<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;

    // add fillable
    protected $fillable = ['name', 'alamat', 'contact'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    // public function keuangans()
    // {
    //     return $this->hasMany(Keuangan::class);
    // }

    // public function pembelians()
    // {
    //     return $this->hasMany(Pembelian::class);
    // }

    // public function persediaans()
    // {
    //     return $this->hasMany(Persediaan::class);
    // }

    // public function asets()
    // {
    //     return $this->hasMany(Aset::class);
    // }
}
