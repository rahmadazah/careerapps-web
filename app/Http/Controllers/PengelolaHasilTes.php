<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilTes;
use App\Models\Tes;

use Illuminate\Support\Facades\Session;

class PengelolaHasilTes extends Controller
{
    protected $tes;

    public function __construct(Tes $tes)
    {
        $this->tes = $tes;
    }
    
    public function tampilkanHasilTes($slug)
    {
        if(!Session::has('api_token')){
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $detailTes = $this->tes->dapatkanBerdasarkanSlug($slug);

        $hasil = HasilTes::dapatkanHasilTes(); 
        $hasilAkhir = null;
        $skor = null;
        $mbtiMapping = null;
        $penjelasan = null;

        switch ($slug) {
            case 'tes-mbti':
                $hasilAkhir = $hasil['mbti'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSemuaSkor($slug);
                    if (!$skor) break;

                    $penjelasan = HasilTes::dapatkanSemuaPenjelasan($slug);
                    if (!$penjelasan) break;

                    $mbtiMapping = HasilTes::mappingMBTI($hasilAkhir);

                    $normalize = function($key) {
                        return strtolower(
                            str_replace([' ', '/', '_'], '-', $key)
                        );
                    };

                    $keyTipe = strtolower($hasilAkhir);
                    $penjelasanTipe = $penjelasan[$keyTipe] ?? '-';

                    $hasilGabungan = [];

                    foreach ($mbtiMapping as $index => $namaPanjang) {

                        $huruf = $hasilAkhir[$index];
                        $lookupKey = $normalize($namaPanjang);

                        $hasilGabungan[$namaPanjang] = [
                            'huruf' => $huruf,
                            'skor' => $skor[$huruf] ?? 0,
                            'penjelasan' => $penjelasan[$lookupKey] ?? '-',
                        ];
                    }
                    $data['detail'] = [
                        'tipe' => [
                            'kode' => $hasilAkhir,
                            'penjelasan' => $penjelasanTipe,
                        ],
                        'dimensi' => $hasilGabungan
                    ];
                    $penjelasanUtama = HasilTes::dapatkanPenjelasanHasil($slug, $hasilAkhir);
                }
                break;

            
            case 'tes-preferensi-bakat':
                $hasilAkhir = $hasil['preferensiBakat'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSemuaSkor($slug);
                    if (!$skor) break;

                    $penjelasan = HasilTes::dapatkanSemuaPenjelasan($slug);  
                    if (!$penjelasan) break;

                    $normalize = function($key) {
                        return strtolower(
                            str_replace([' ', '/', '_'], '-', $key)
                        );
                    };

                    $hasilGabungan = collect($skor)
                        ->mapWithKeys(function($value, $key) use ($penjelasan, $normalize) {
                            $lookupKey = $normalize($key);
                            return [
                                $key => [
                                    'skor' => $value,
                                    'penjelasan' => $penjelasan[$lookupKey] ?? '-',
                                ]
                            ];
                        })
                        ->sortBy('skor') 
                        ->toArray();

                    $data['detail'] = $hasilGabungan;
                    $penjelasanUtama = HasilTes::dapatkanPenjelasanHasil($slug, $hasilAkhir);
                    $skorUtama = HasilTes::dapatkanSkorUtama($slug, $hasilAkhir);
                }
                break;

            case 'tes-tipe-pekerjaan':
                $hasilAkhir = $hasil['tipePekerjaan'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSemuaSkor($slug);
                    if (!$skor) break;

                    $penjelasan = HasilTes::dapatkanSemuaPenjelasan($slug);  

                    if (!$penjelasan) break;

                    $normalize = function($key) {
                        return strtolower(
                            str_replace([' ', '/', '_'], '-', $key)
                        );
                    };

                    $hasilGabungan = collect($skor)
                        ->mapWithKeys(function($value, $key) use ($penjelasan, $normalize) {
                            $lookupKey = $normalize($key);
                            return [
                                $key => [
                                    'skor' => $value,
                                    'penjelasan' => $penjelasan[$lookupKey] ?? '-',
                                ]
                            ];
                        })
                        ->sortByDesc('skor') 
                        ->toArray();

                    $data['detail'] = $hasilGabungan;
                    $skorUtama = HasilTes::dapatkanSkorUtama($slug, $hasilAkhir);
                    $penjelasanUtama = HasilTes::dapatkanPenjelasanHasil($slug, $hasilAkhir);
                }
                break;
            default:
                    return redirect()->route('tes.detail-hasil')->with('error', 'Tes tidak ditemukan');
        }

        return view('hasil-tes', [
            'detailTes' => $detailTes,
            'hasilAkhir' => $hasilAkhir,
            'skor' => $skor,
            'skorUtama' => $skorUtama ?? null,
            'mbtiMapping' => $mbtiMapping,
            'penjelasan' => $penjelasan,
            'penjelasanUtama' => $penjelasanUtama,
            'detail' => $data['detail'] ?? null,
            'slug' => $slug,
        ]);

    }

    public function tampilkanDetailHasilTes($slug)
    {
        if(!Session::has('api_token')){
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $detailTes = $this->tes->dapatkanBerdasarkanSlug($slug);

        $hasil = HasilTes::dapatkanHasilTes(); 
        $hasilAkhir = null;
        $skor = null;
        $mbtiMapping = null;
        $penjelasan = null;

        switch ($slug) {
            case 'tes-mbti':
                $hasilAkhir = $hasil['mbti'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSemuaSkor($slug);
                    if (!$skor) break;

                    $penjelasan = HasilTes::dapatkanSemuaPenjelasan($slug);
                    if (!$penjelasan) break;

                    $mbtiMapping = HasilTes::mappingMBTI($hasilAkhir);

                    $normalize = function($key) {
                        return strtolower(
                            str_replace([' ', '/', '_'], '-', $key)
                        );
                    };

                    $keyTipe = strtolower($hasilAkhir);
                    $penjelasanTipe = $penjelasan[$keyTipe] ?? '-';

                    $hasilGabungan = [];

                    foreach ($mbtiMapping as $index => $namaPanjang) {

                        $huruf = $hasilAkhir[$index];
                        $lookupKey = $normalize($namaPanjang);

                        $hasilGabungan[$namaPanjang] = [
                            'huruf' => $huruf,
                            'skor' => $skor[$huruf] ?? 0,
                            'penjelasan' => $penjelasan[$lookupKey] ?? '-',
                        ];
                    }
                    $data['detail'] = [
                        'tipe' => [
                            'kode' => $hasilAkhir,
                            'penjelasan' => $penjelasanTipe,
                        ],
                        'dimensi' => $hasilGabungan
                    ];
                }
                break;

            
            case 'tes-preferensi-bakat':
                $hasilAkhir = $hasil['preferensiBakat'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSemuaSkor($slug);
                    if (!$skor) break;

                    $penjelasan = HasilTes::dapatkanSemuaPenjelasan($slug);  
                    if (!$penjelasan) break;

                    $normalize = function($key) {
                        return strtolower(
                            str_replace([' ', '/', '_'], '-', $key)
                        );
                    };

                    $hasilGabungan = collect($skor)
                        ->mapWithKeys(function($value, $key) use ($penjelasan, $normalize) {
                            $lookupKey = $normalize($key);
                            return [
                                $key => [
                                    'skor' => $value,
                                    'penjelasan' => $penjelasan[$lookupKey] ?? '-',
                                ]
                            ];
                        })
                        ->sortBy('skor') 
                        ->toArray();

                    $data['detail'] = $hasilGabungan;
                }
                break;

            case 'tes-tipe-pekerjaan':
                $hasilAkhir = $hasil['tipePekerjaan'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSemuaSkor($slug);
                    if (!$skor) break;

                    $penjelasan = HasilTes::dapatkanSemuaPenjelasan($slug);  
                    if (!$penjelasan) break;

                    $normalize = function($key) {
                        return strtolower(
                            str_replace([' ', '/', '_'], '-', $key)
                        );
                    };

                    $hasilGabungan = collect($skor)
                        ->mapWithKeys(function($value, $key) use ($penjelasan, $normalize) {
                            $lookupKey = $normalize($key);
                            return [
                                $key => [
                                    'skor' => $value,
                                    'penjelasan' => $penjelasan[$lookupKey] ?? '-',
                                ]
                            ];
                        })
                        ->sortByDesc('skor') 
                        ->toArray();

                    $data['detail'] = $hasilGabungan;
                }
                break;
            default:
                    return redirect()->route('tes.detail-hasil')->with('error', 'Tes tidak ditemukan');
        }

        return view('detail-hasil-tes', [
            'detailTes' => $detailTes,
            'hasilAkhir' => $hasilAkhir,
            'skor' => $skor,
            'mbtiMapping' => $mbtiMapping,
            'penjelasan' => $penjelasan,
            'detail' => $data['detail'] ?? null,
            'slug' => $slug,
        ]);

    }

}
