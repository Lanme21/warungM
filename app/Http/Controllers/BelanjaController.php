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
            'kode_barang' => 'required|string|max:30',
            'nama' => 'nullable|string|required_if:is_new,true',
            'kategori' => 'nullable|string|required_if:is_new,true',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'jumlah' => 'required|integer',
            'is_new' => 'sometimes|boolean',
        ], [
            'kode_barang.required' => 'kode wajib diisi.',
            'kode_barang.max' => 'kode tidak boleh lebih dari 30 karakter.',
            'nama.required_if' => 'Nama barang wajib diisi untuk barang baru.',
            'kategori.required_if' => 'Kategori wajib diisi untuk barang baru.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.integer' => 'Harga Jual harus berupa number.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.integer' => 'Harga beli harus berupa number.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa number.',
        ]);

        $barang = Barang::find($validatedData['kode_barang']);

        if (!$barang) {
            // Buat barang baru jika tidak ada
            $barang = Barang::create([
                'kode' => $validatedData['kode_barang'],
                'nama' => $validatedData['nama'],
                'kategori' => $validatedData['kategori'],
                'satuan' => 'Pcs', // Default, atau bisa ditambahkan di form
            ]);
            Etalase::create(['barang_kode' => $barang->kode]);
        }

        $belanja = Belanja::create($validatedData);
        $etalase = Etalase::where("barang_kode", $validatedData['kode_barang'])->firstOrFail();
        $etalase->update([
            "harga_lama" => $etalase->harga_baru,
            "harga_baru" => $validatedData["harga_beli"],
            "harga_jual" => $validatedData["harga_jual"],
            "stok" => $etalase->stok + $validatedData["jumlah"],
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
