<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Etalase;
use Illuminate\Http\Request;
use PhpParser\Lexer\TokenEmulator\KeywordEmulator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('barang.dashboard');
    }
    public function index()
    {
        $data = [
            'barangs' => Barang::all("kode", "nama", "satuan", "kategori"), // Use this if you want to fetch a single etalase per barang
        ];
        return view('barang.databarang', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $etalases = Etalase::all();
        return view('barang.tambahbarang');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'kode' => 'string|required|unique:barangs|max:30',
            'nama' => 'string|required',
            'satuan' => 'string|required',
            'kategori' => 'string|required',
        ], [
            'kode.required' => 'kode wajib diisi.',
            'kode.max' => 'kode tidak boleh lebih dari 30 karakter.',
            'kode.string' => 'kode harus berupa teks.',
            'kode.unique' => 'kode barang sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'satuan.required' => 'Satuan wajib diisi.',
            'satuan.string' => 'Satuan harus berupa teks.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.string' => 'Kategori harus berupa teks.',
        ]);


        $barang = Barang::create($validatedData); // Uses mass assignment
        $etalase = Etalase::create(['barang_kode' => $validatedData['kode']]);
        alert()->success('Success', 'Data Berhasil Ditambahkan');
        return redirect("barang");
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $kode)
    {
        $barang = Barang::findOrFail($kode);
        $etalases = Etalase::all();
        return view('barang.editbarang', compact('barang', 'etalases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kode)

    {
        $barang = Barang::findOrFail($kode);
        $validatedData = $request->validate([
            'nama' => 'string|required',
            'satuan' => 'string|required',
            'kategori' => 'string|required',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'satuan.required' => 'Satuan wajib diisi.',
            'satuan.string' => 'Satuan harus berupa teks.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.string' => 'Kategori harus berupa teks.',
        ]);


        $barang->update($validatedData); // Uses mass assignment
        alert()->success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('barang.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kode)
    {
        $barang = Barang::findOrFail($kode);
        Etalase::where('barang_kode', $kode)->delete();
        $barang->delete();
        alert()->success('Success', 'Data Berhasil Dihapus');
        return redirect()->route('barang.index');
    }

    // menampilkan barang yang tersedia dalam etalase
    public function getdataetalase()
    {
        $etalase = Etalase::with('barangs')->get()->where('stok', '>=', 1);
        return response()->json([
            'success' => true,
            'message' => 'Data posts berhasil dimuat.',
            'data'    => $etalase,
        ], 200);
    }
}
