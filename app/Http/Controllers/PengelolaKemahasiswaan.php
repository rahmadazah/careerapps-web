<?php

namespace App\Http\Controllers;

use App\Models\Kemahasiswaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengelolaKemahasiswaan extends Controller
{
    protected $kemahasiswaan;

    public function __construct(Kemahasiswaan $kemahasiswaan)
    {
        $this->kemahasiswaan = $kemahasiswaan;
    }

    public function tampilkanHalaman()
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $data = $this->kemahasiswaan->dapatkanData();

        if (!$data) {
            return view('kemahasiswaan', [
                'daftarOrganisasi' => [],
                'daftarKepanitiaan' => [],
                'daftarPencapaian' => [],
                'error' => 'Gagal mengambil data dari API.'
            ]);
        }

        return view('kemahasiswaan', [
            'daftarOrganisasi' => $data['Organization'],
            'daftarKepanitiaan' => $data['Volunteer'],
            'daftarPencapaian' => $data['Achievement'],
        ]);
    }
}
