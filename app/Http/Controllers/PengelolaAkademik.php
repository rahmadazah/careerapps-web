<?php

namespace App\Http\Controllers;

use App\Models\Akademik;
use Illuminate\Support\Facades\Session;

class PengelolaAkademik extends Controller
{
    protected $akademik;

    public function __construct(Akademik $akademik)
    {
        $this->akademik = $akademik;
    }

    public function tampilkanSemua()
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $data = $this->akademik->dapatkanSemua();

        if (!$data) {
            return view('akademik', [
                'kumpulanSemester' => [],
                'kumpulanPKL' => [],
                'kumpulanKKN' => [],
                'error' => 'Gagal mengambil data dari API.',
            ]);
        }

        return view('akademik', $data);
    }

    public function tampilkanKHS($semester)
    {
        $detail = $this->akademik->detailKHS($semester);

        if (!$detail) {
            return redirect()->route('akademik')->with('error', 'Semester tidak ditemukan.');
        }

        return view('khs', [
            'semester' => $detail['semester'],
            'kumpulanMK' => $detail['kumpulanMK'],
            'dataMK' => $detail['dataMK'],
        ]);
    }
}
