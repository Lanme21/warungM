<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
     use HasFactory;
    protected $table = 'transaksi_details';
   protected $primaryKey = 'id';
   protected $keyType = 'integer';
   public $timestamps = true;  
   public $incrementing = true;
   protected $fillable = [
       'faktur_transaksi',
       'barang_kode',
       'jumlah',
       'harga',
   ];

   public function barangs()
   {
       return $this->belongsTo(Barang::class, 'barang_kode', 'kode');
   }
   public function transaksi()
   {
       return $this->belongsTo(Transaksi::class, 'faktur_transaksi', 'faktur');
   }
}
