<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PengelolaKRS extends Controller
{
    public function detailKRS($id)
    {
        $token = Session::get('api_token');

        if (!$token) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $response = Http::withToken($token)->get('https://devskripsi.com/api/student/detail');

        if ($response->successful()) {
            $data = $response->json()['data'];

            $dataAkademik = $data['Academic'][0] ?? null;

            if ($dataAkademik && isset($dataAkademik['KRS'])) {
                $kumpulanSemester = collect($dataAkademik['KRS'])->sortByDesc('semester')->values();
            } else {
                $kumpulanSemester = collect([]);
            }

            $semuaKRS = $dataAkademik['KRS'];
            $KRS = collect($semuaKRS)->firstWhere('id', $id);
            $kumpulanMK = $KRS['CourseTaken'] ?? [];
            $dataMK = $kumpulanMK[0]['course'] ?? null;

            return view('krs', compact('KRS', 'kumpulanSemester', 'kumpulanMK', 'dataMK'));
        } else {
            return redirect()->route('akademik')->with('error', 'KRS tidak ditemukan.');
        }
    }
}
