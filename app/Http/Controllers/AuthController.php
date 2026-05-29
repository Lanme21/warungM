<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Etalase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('auth.login');
    }
     public function authenticate(Request $request)
    {
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.string' => 'Email harus berupa string',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa string',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            alert()->success('Login Berhasil', 'Selamat datang di dashboard!');
            return redirect('/dashboard');
        }

        alert()->error('Login Gagal', 'Email atau password salah. Coba lagi!');
        return back()->withInput($request->only('email'));
    }
    public function register(){
        return view('auth.register');
    }
    public function registerUser(Request $request)  
    {
        
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',    
            'email.string' => 'Email harus berupa string',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa string',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        // Buat user baru
        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        alert()->success('Registrasi Berhasil', 'Register akun anda berhasil. Silakan login!');
        return redirect('/login');  
        
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        alert()->success('Logout Berhasil', 'Anda telah keluar dari sistem.');
        return redirect('/login');
    }
    public function index()
    {
        return view('auth.index');
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
        //
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
        //
    }
    public function fetchBarang(Request $request) : JsonResponse
    {
        
        $kodeBarang = $request->input('kode_barang');
        $etalase = Etalase::with('barangs')->where('barang_kode', $kodeBarang)->first();

        if ($etalase) {
            return response()->json([
                'success' => true,
                'data' => $etalase
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }
        
    }
}
