<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = [
        'kode',
        'nama',
        'satuan',
        'kategori',
    ];
    public function etalase()
    {
        return $this->hasOne(Etalase::class, 'barang_kode', 'kode');
    }
    public function belanja()
    {
        return $this->hasMany(Belanja::class);
    }
    public function detailTransaksi()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
