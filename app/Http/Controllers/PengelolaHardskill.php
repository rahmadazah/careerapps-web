<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Support\Facades\Session;

class PengelolaHardskill extends Controller
{
    protected $mataKuliah;

    public function __construct()
    {
        $this->mataKuliah = new MataKuliah();
    }

    public function tampilkanSemua()
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $mkRelevan = $this->mataKuliah->dapatkanMKRelevan();
        $mkRekomendasi = $this->mataKuliah->dapatkanMKRekomendasi();

        return view('hardskill', compact('mkRelevan', 'mkRekomendasi'));
    }

    public function tampilkanDetailMKRelevan($slug)
    {
        $detail = $this->mataKuliah->dapatkanDetailMKRelevan($slug);

        if (!$detail) {
            return redirect()->route('dashboard.hardskill')->with('error', 'Mata kuliah tidak ditemukan.');
        }

        return view('mk-relevan', compact('detail'));
    }

    public function tampilkanDetailMKRekomendasi($slug)
    {
        $detail = $this->mataKuliah->dapatkanDetailMKRekomendasi($slug);

        if (!$detail) {
            return redirect()->route('dashboard.hardskill')->with('error', 'Mata kuliah tidak ditemukan.');
        }

        return view('mk-rekomendasi', compact('detail'));
    }
}
