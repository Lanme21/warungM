<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $primaryKey = 'cart_kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = [
        'cart_kode',
        'cart_barang',
        'cart_satuan',
        'cart_jumlah',
        'cart_harga',
    ];
}
