<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
      use HasFactory;
   
   protected $table = 'transaksis';
   protected $primaryKey = 'faktur';
   public $incrementing = false;
   protected $keyType = 'string';
   public $timestamps = true;  
   protected $fillable = [
       'faktur',
       'tanggal_faktur',
       'jumlah_Item',
       'total_harga',
       'status_transaksi',
   ];
   public function detailTransaksi()
   {
       return $this->hasMany(TransaksiDetail::class, 'faktur_transaksi', 'faktur');
   }
}
