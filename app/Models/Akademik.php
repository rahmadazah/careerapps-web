<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Akademik
{
    protected $baseUrl = 'https://devskripsi.com/api/student/detail';

    public function dapatkanSemua()
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = Http::withToken($token)->get($this->baseUrl);

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json()['data'];

        $dataAkademik = $data['Academic'][0] ?? null;
        $kumpulanSemester = collect($dataAkademik['KRS'] ?? [])->sortByDesc('semester')->values();

        $kumpulanSemester = $kumpulanSemester->map(function ($semester, $index) use ($kumpulanSemester) {
            $semester['ips'] = number_format($semester['ips'], 2);
            $semester['ipk'] = number_format($semester['ipk'], 2);
            $semester['sks_kumulatif'] = $kumpulanSemester->slice($index)->sum('sks');
            $semester['rekomendasi_sks'] = min(24, 144 - $semester['sks_kumulatif']);
            return $semester;
        });

        $kumpulanPKL = collect($data['Pkl'] ?? [])->map(function ($item) {
            $item['dateStart'] = Carbon::parse($item['dateStart'])->translatedFormat('d F Y');
            $item['dateEnd'] = Carbon::parse($item['dateEnd'])->translatedFormat('d F Y');
            $item['status'] = Carbon::now()->gt(Carbon::parse($item['dateEnd'])) ? 'Selesai' : 'Sedang Berlangsung';
            return $item;
        });

        $kumpulanKKN = collect($data['KKN'] ?? [])->map(function ($item) {
            $item['startDate'] = Carbon::parse($item['startDate'])->translatedFormat('d F Y');
            $item['endDate'] = Carbon::parse($item['endDate'])->translatedFormat('d F Y');
            $item['status'] = Carbon::now()->gt(Carbon::parse($item['endDate'])) ? 'Selesai' : 'Sedang Berlangsung';
            return $item;
        });

        return [
            'kumpulanSemester' => $kumpulanSemester,
            'kumpulanPKL' => $kumpulanPKL,
            'kumpulanKKN' => $kumpulanKKN,
        ];
    }

    public function semuaSemester(): Collection
    {
        $dataAkademik = $this->dapatkanSemua(); 
        return isset($dataAkademik['kumpulanSemester'])
        ? collect($dataAkademik['kumpulanSemester'])->sortByDesc('semester')->values()
        : collect([]);

    }

    public function dapatkanSemester($semester)
    {
        $semuaSemester = $this->semuaSemester();
        return $semuaSemester->firstWhere('semester', (int) $semester);
    }

    public function detailKHS($semester)
    {
        $semesterData = $this->dapatkanSemester($semester);

        if (!$semesterData) return null;

        $kumpulanMK = collect($semesterData['CourseTaken'] ?? [])->map(function ($mk) {
            if (isset($mk['grade'])) {
                $mk['grade'] = strtoupper(str_replace(['_plus', '_minus'], ['+', '-'], $mk['grade']));
            }
            return $mk;
        });

        $dataMK = $kumpulanMK->pluck('course')->unique('code')->values();

        return [
            'semester' => $semesterData,
            'kumpulanMK' => $kumpulanMK,
            'dataMK' => $dataMK,
        ];
    }
}
