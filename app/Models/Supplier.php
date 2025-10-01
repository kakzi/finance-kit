<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    //
    use HasFactory;

    // add fillable
    protected $fillable = ['name', 'alamat', 'kontak'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    // public function pembelians()
    // {
    //     return $this->hasMany(Pembelian::class);
    // }
}
