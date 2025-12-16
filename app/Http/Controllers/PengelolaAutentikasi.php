<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Mahasiswa;

class PengelolaAutentikasi extends Controller
{
    public function tampilkanHalamanMasuk()
    {
        return view('masuk');
    }

    public function masuk(Request $request)
    {
        // 1. VALIDASI INPUT KOSONG
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]
        );

        // 2. PROSES LOGIN KE API
        $token = Mahasiswa::login($request->email, $request->password);

        if ($token) {
            Mahasiswa::ambilProfil();
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        // 3. EMAIL / PASSWORD SALAH
        return redirect()->back()->with('error', 'Email atau password salah.');
    }


    public function keluar()
    {
        Session::flush();
        return redirect()->route('masuk')->with('success', 'Logout berhasil.');
    }
}
