<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PengelolaProfil extends Controller
{
    public function tampilkanProfil()
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $profil = Mahasiswa::ambilProfil();

        if ($profil) {
            return view('profil', ['profile' => $profil]);
        }

        return view('profil', ['profile' => [], 'error' => 'Gagal mengambil data dari API']);
    }

    public function ubahKataSandi()
    {
        Log::info('User mengakses ubah password', [
            'student_id' => Session::get('student_id'),
            'time' => now(),
        ]);

        Session::flush();
        return redirect()->away('https://bais.ub.ac.id/');
    }
}
