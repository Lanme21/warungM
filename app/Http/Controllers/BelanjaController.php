<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Belanja;
use App\Models\Etalase;
use Illuminate\Http\Request;

class BelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            // 'barang' => Barang::all("kode", "nama", "satuan", "kategori"),
            'belanja' => Belanja::with('barang')->get(),
        ];
        // dd($data);
        return view('belanja.databelanja', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = Barang::all("kode", "nama", "satuan");

        return view('belanja.tambahbelanja', ['barang' => $barang]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'string|required|max:30',
            'harga_beli' => 'integer|required',
            'harga_jual' => 'integer|required',
            'jumlah' => 'integer|required',
        ], [
            'kode_barang.required' => 'kode wajib diisi.',
            'kode_barang.max' => 'kode tidak boleh lebih dari 30 karakter.',
            'kode_barang.integer' => 'kode harus berupa number.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.integer' => 'Harga Jual harus berupa number.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.integer' => 'Harga beli harus berupa number.',
            'jumlah.required' => 'Kategori wajib diisi.',
            'jumlah.integer' => 'Kategori harus berupa number.',
        ]);


        $belanja = Belanja::create($validatedData);
        $hargaEtalase  = Etalase::where("barang_kode", $validatedData['kode_barang'])->first("harga_baru");
        $stokEtalase  = Etalase::where("barang_kode", $validatedData['kode_barang'])->first("stok");
        // dd($hargaEtalase['harga_baru'] , $stokEtalase['stok']);
        $etalase  = Etalase::where("barang_kode", $validatedData['kode_barang'])->update([
            "harga_lama" => $hargaEtalase["harga_baru"],
            "harga_baru" => $validatedData["harga_beli"],
            "harga_jual" => $validatedData["harga_jual"],
            "stok" => $stokEtalase["stok"] + $validatedData["jumlah"],
        ]);

        alert()->success('Success', 'Data Berhasil Ditambahkan');
        return redirect("belanja");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $belanja = Belanja::findOrFail($id);
        $stokEtalase  = Etalase::where("barang_kode", $belanja->kode_barang)->first("stok");
        $etalase  = Etalase::where("barang_kode", $belanja->kode_barang)->update([
            "stok" => $stokEtalase["stok"] - $belanja->jumlah,
        ]);
        $belanja->delete();
        alert()->success('Success', 'Data Berhasil Dihapus');
        return redirect("belanja");
    }
}
