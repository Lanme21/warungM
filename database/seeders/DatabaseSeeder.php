<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Etalase;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Barang::insert([
            [
                'kode' => 'BRG001',
                'nama' => 'Indomie Goreng',
                'satuan' => 'Pcs',       
                'kategori' => 'Makanan',
            ]]);
        Barang::insert([ 
            [
                'kode' => 'BRG002',
                'nama' => 'Teh Botol Sosro',
                'satuan' => 'Pcs',
                'kategori' => 'Minuman',
            ]]);
        Barang::insert([  
            [
                'kode' => 'BRG003',
                'nama' => 'Beras 5kg',
                'satuan' => 'Paket',
                'kategori' => 'Sembako',
            ]]);
        Barang::insert([
            [   
                'kode' => 'BRG004',
                'nama' => 'Susu UHT 1L',
                'satuan' => 'Pcs',
                'kategori' => 'Minuman',
            ]
        ]);
        Etalase::insert([
            [
                'barang_kode' => 'BRG001',
                   ],
            [
                'barang_kode' => 'BRG002',
                   ],
            [
                'barang_kode' => 'BRG003',
                   ],
            [
                'barang_kode' => 'BRG004',
                    ]
        ]);
    }       
}
