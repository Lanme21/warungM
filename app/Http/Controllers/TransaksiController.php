<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cart;
use App\Models\Etalase;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'transaksi' => Transaksi::all("faktur", "tanggal_faktur", "jumlah_Item", "total_harga", "status_transaksi"),
        ];
        return view('transaksi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cart_kode' => 'required|string',
            'cart_barang' => 'required|string',
            'cart_satuan' => 'required|string',
            'cart_jumlah' => 'required|numeric',
            'cart_harga' => 'required|numeric',
        ], [
            'cart_kode.required' => 'Kode barang wajib diisi.',
            'cart_kode.string' => 'Kode barang harus berupa teks.',
            'cart_barang.required' => 'Nama barang wajib diisi.',
            'cart_satuan.required' => 'Satuan wajib diisi.',
            'cart_jumlah.required' => 'Jumlah wajib diisi.',
            'cart_jumlah.numeric' => 'Jumlah harus berupa angka.',
            'cart_harga.required' => 'Harga wajib diisi.',
            'cart_harga.numeric' => 'Harga harus berupa angka.',
        ]);


        $cart = Cart::where('cart_kode', $request['cart_kode'])->first("cart_kode");

        if ($cart) {
            // Jika item sudah ada di keranjang, perbarui jumlahnya
            $cart->cart_jumlah += $request['cart_jumlah'];
            $cart->cart_harga += $request['cart_harga'];
            $cart->save();
        } else {
            // Jika item belum ada di keranjang, tambahkan item baru
            Cart::create($validatedData);
        }
        return redirect("/cart")->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $faktur)
    {
        $transaksis = TransaksiDetail::with('barangs.etalase')->where('faktur_transaksi', $faktur)->get();

        return view('transaksi.show', compact('transaksis'));
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
        //
    }
    public function cart()
    {

        return view('transaksi.cart');
    }
    public function clearCart()
    {
        Cart::truncate(); // Hapus semua data dari tabel carts
        alert()->success('Success', 'Keranjang Berhasil Dikosongkan');
        return redirect("cart");
    }
    public function checkout(Request $request)
    {
        // Membuat Nomor Faktur
        $lastTransaksi = Transaksi::orderBy('faktur', 'desc')->first();

        if ($lastTransaksi) {
            $lastFakturNumber = (int) substr($lastTransaksi->faktur, 3);
            $newFakturNumber = $lastFakturNumber + 1;
        } else {
            $newFakturNumber = 1;
        }
        $faktur = 'FKT' . str_pad($newFakturNumber, 6, '0', STR_PAD_LEFT); // hasil dari membuat no faktur
        $now = Carbon::now('Asia/Jakarta'); // Gunakan zona waktu WIB (atau zona waktu lokal Anda)
        Carbon::setLocale('id'); // zona yang di pakai
        $tanggalFaktur = $now->isoFormat('dddd, D MMMM YYYY H:mm:ss') . ' WIB';
        $jumlahProduct = Cart::count();
        $totalBayar = Cart::sum("cart_harga");
        $cart = Cart::all();
        $data = [
            "faktur" => $faktur,
            "tanggal_faktur" => $tanggalFaktur,
            "jumlah_Item" => $jumlahProduct,
            "total_harga" => $totalBayar,
            "status_transaksi" => "Lunas",
        ];
        foreach ($cart as $key => $value) {

            TransaksiDetail::create([
                "faktur_transaksi" => $faktur,
                "barang_kode" => $value->cart_kode,
                "jumlah" => $value->cart_jumlah,
                "harga" => $value->cart_harga,
            ]);
            $stokEtalase  = Etalase::where("barang_kode", $value->cart_kode)->first("stok");
            $etalase  = Etalase::where("barang_kode", $value->cart_kode)->update([
                "stok" => $stokEtalase["stok"] - $value->cart_jumlah,
            ]);
        }
        Cart::truncate();
        Transaksi::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Item berhasil ditambahkan ke keranjang.',
            'data' => $request->all()
        ], 201);
    }
    public function generateFaktur()
    {
        // Membuat Nomor Faktur
        $lastTransaksi = Transaksi::orderBy('faktur', 'desc')->first();

        if ($lastTransaksi) {
            $lastFakturNumber = (int) substr($lastTransaksi->faktur, 3);
            $newFakturNumber = $lastFakturNumber + 1;
        } else {
            $newFakturNumber = 1;
        }
        $faktur = 'FKT' . str_pad($newFakturNumber, 6, '0', STR_PAD_LEFT); // hasil dari membuat no faktur
        $now = Carbon::now('Asia/Jakarta'); // Gunakan zona waktu WIB (atau zona waktu lokal Anda)
        Carbon::setLocale('id'); // zona yang di pakai
        $tanggalFaktur = $now->isoFormat('dddd, D MMMM YYYY H:mm:ss') . ' WIB';
        $jumlahProduct = Cart::count();
        dd($jumlahProduct);
        $totalBayar = Cart::sum("cart_harga");
        $cart = Cart::all();
        $data = [
            "faktur" => $faktur,
            "tanggal_faktur" => $tanggalFaktur,
            "jumlah_Item" => $jumlahProduct,
            "total_harga" => $totalBayar,
            "status_transaksi" => "Lunas",
        ];
        foreach ($cart as $key => $value) {

            TransaksiDetail::create([
                "faktur_transaksi" => $faktur,
                "barang_kode" => $value->cart_kode,
                "jumlah" => $value->cart_jumlah,
                "harga" => $value->cart_harga,
            ]);
            $stokEtalase  = Etalase::where("barang_kode", $value->cart_kode)->first("stok");
            $etalase  = Etalase::where("barang_kode", $value->cart_kode)->update([
                "stok" => $stokEtalase["stok"] - $value->cart_jumlah,
            ]);
        }
        Cart::truncate();
        Transaksi::create($data);
    }
    public function mycart(Request $request)
    {

        $validatedData = $request->validate([
            'cart_kode' => 'required|string',
            'cart_barang' => 'required|string',
            'cart_satuan' => 'required|string',
            'cart_jumlah' => 'required|numeric',
            'cart_harga' => 'required|numeric',
        ], [
            'cart_kode.required' => 'Kode barang wajib diisi.',
            'cart_kode.string' => 'Kode barang harus berupa teks.',
            'cart_barang.required' => 'Nama barang wajib diisi.',
            'cart_satuan.required' => 'Satuan wajib diisi.',
            'cart_jumlah.required' => 'Jumlah wajib diisi.',
            'cart_jumlah.numeric' => 'Jumlah harus berupa angka.',
            'cart_harga.required' => 'Harga wajib diisi.',
            'cart_harga.numeric' => 'Harga harus berupa angka.',
        ]);
        // cari existing cart item berdasarkan kode (gunakan validated data)
        $cart = Cart::where('cart_kode', $validatedData['cart_kode'])->first();

        if ($cart) {
            // Jika item sudah ada di keranjang, perbarui jumlah dan harga (pastikan konversi tipe)
            $cart->cart_jumlah = $cart->cart_jumlah + (int) $validatedData['cart_jumlah'];
            $cart->cart_harga = $cart->cart_harga + (float) $validatedData['cart_harga'];
            $cart->save();
            // kembalikan model yang telah diperbarui
            $cartData = $cart->fresh();
        } else {
            // Jika item belum ada di keranjang, tambahkan item baru
            $cartData = Cart::create($validatedData);
        }
        return response()->json([
            'success' => true,
            'message' => 'Item berhasil ditambahkan ke keranjang.',
            'data' => $cartData
        ], 201);
    }
    public function fetchcartitems()
    {
        $cartItems = Cart::all();
        $totalHarga = Cart::sum("cart_harga");

        return response()->json([
            'success' => true,
            'message' => 'Data keranjang berhasil dimuat.',
            'data'    => $cartItems,
            'total' => $totalHarga,
        ], 200);
    }
}
