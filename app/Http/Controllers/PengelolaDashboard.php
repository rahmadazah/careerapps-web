<?php

namespace App\Http\Controllers;

use App\Models\HasilTes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Mahasiswa;

class PengelolaDashboard extends Controller
{
    public function tampilkanDashboard()
{
    if (!Session::has('api_token')) {
        return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
    }

    $hasilTes = HasilTes::dapatkanHasilTes();
    $rekomendasiKarier = Mahasiswa::ambilRekomendasiKarier();

    return view('dashboard', compact('hasilTes', 'rekomendasiKarier'));
}

}
