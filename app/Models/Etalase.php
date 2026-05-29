<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etalase extends Model
{
    use HasFactory;
    protected $table = 'etalases';
   protected $primaryKey = 'id';
   protected $keyType = 'integer';
   public $timestamps = true;  
   public $incrementing = true;
   protected $fillable = [
       'barang_kode',
       'harga_lama',
       'harga_baru',
       'harga_jual',
       'stok'
   ];

   public function barangs()
   {
       return $this->belongsTo(Barang::class, 'barang_kode', 'kode');
   }


}
