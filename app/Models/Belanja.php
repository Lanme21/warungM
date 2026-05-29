<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belanja extends Model
{
    protected $table = 'belanjas';
   protected $primaryKey = 'id';
   public $timestamps = true;  
   public $incrementing = true;
   protected $fillable = [
       'kode_barang',
        'harga_beli',
        'harga_jual',
        'jumlah'
   ];

   public function barang()
   {
       return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
   }
}
