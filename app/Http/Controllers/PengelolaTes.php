<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tes;
use App\Models\HasilTes;
use Carbon\Carbon;

class PengelolaTes extends Controller
{ 
    protected $tes;

    public function __construct(Tes $tes)
    {
        $this->tes = $tes;
    }
    
    public function tampilkanDaftarTes()
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $kumpulanTes = $this->tes->dapatkanSemua();

        if ($kumpulanTes) {
            return view('daftar-tes', compact('kumpulanTes'));
        }

        return view('daftar-tes', [
            'daftarTes' => [],
            'error' => 'Gagal mengambil data dari API.'
        ]);
    }

    public function tampilkanDetailTes($slug)
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
                    $mbtiMapping = HasilTes::mappingMBTI($hasilAkhir);
                    $penjelasan = HasilTes::dapatkanPenjelasanHasil($slug, $hasilAkhir);
                }
                break;
            
            case 'tes-preferensi-bakat':
                $hasilAkhir = $hasil['preferensiBakat'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSkorUtama($slug, $hasilAkhir);
                    $penjelasan = HasilTes::dapatkanPenjelasanHasil($slug, $hasilAkhir);
                }
                break;
           
            case 'tes-tipe-pekerjaan':
                $hasilAkhir = $hasil['tipePekerjaan'] ?? null;

                if ($hasilAkhir) {
                    $skor = HasilTes::dapatkanSkorUtama($slug, $hasilAkhir);
                    $penjelasan = HasilTes::dapatkanPenjelasanHasil($slug, $hasilAkhir);
                }
                break;
            
            default:
                    return redirect()->route('tes.daftar')->with('error', 'Tes tidak ditemukan');
        }

        return view('detail-tes', [
            'detailTes' => $detailTes,
            'hasilAkhir' => $hasilAkhir,
            'skor' => $skor,
            'mbtiMapping' => $mbtiMapping,
            'penjelasan' => $penjelasan,
            'slug' => $slug,
        ]);

    }

    public function tampilkanPersetujuanPengguna($slug)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $hasil = $this->tes->dapatkanPersetujuanPengguna($slug);
    
        if (!$hasil) {
            return redirect()->route('tes.detail')->with('error', 'Tes tidak ditemukan.');
        }
 
        $tes = $hasil['tes'];
        $persetujuanPengguna = $hasil['persetujuanPengguna'];

        return view('persetujuan-pengguna', compact('tes', 'persetujuanPengguna'));
    }

    public function mulaiTes($slug)
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $tes = $this->tes->dapatkanBerdasarkanSlug($slug);

        if (!$tes) {
            return redirect()->route('daftar-tes')->with('error', 'Tes tidak ditemukan.');
        }

        $assessmentId = $tes['id'];
        $pertanyaan = Tes::dapatkanPertanyaan($assessmentId, $token);

        switch ($slug) {
            case 'tes-mbti':
                $pertanyaan = collect($pertanyaan)->map(function ($p) {
                    $pilihanAPI = $p['Choices'] ?? [];

                    $choices = collect($pilihanAPI)
                        ->take(2)
                        ->values()
                        ->map(function ($choice, $i) {
                            $huruf = $i === 0 ? 'A' : 'B';
                            return [
                                'huruf' => $huruf,             
                                'text' => $choice['label'] ?? '-',
                            ];
                        })
                        ->toArray();

                    return [
                        'id' => $p['id'],
                        'questionText' => $p['questionText'] ?? 'Pertanyaan tidak diketahui',
                        'Choices' => $choices,
                        'questionType' => 'RADIO',
                    ];
                })->toArray();
                break;


            case 'tes-preferensi-bakat':
                $pertanyaan = collect($pertanyaan)->map(function ($p) {
                    return [
                        'id' => $p['id'],
                        'questionText' => $p['questionText'],
                        'Choices' => [
                            ['huruf' => 'A', 'text' => 'Ya'],
                            ['huruf' => 'B', 'text' => 'Mungkin'],
                            ['huruf' => 'C', 'text' => 'Tidak'],
                        ],
                        'questionType' => 'RADIO',
                    ];
                })->toArray();
                break;


            case 'tes-tipe-pekerjaan':
                $pertanyaan = collect($pertanyaan)->map(function ($p) {
                    return [
                        'id' => $p['id'],
                        'questionText' => $p['questionText'],
                        'Choices' => collect($p['Choices'])->take(5)->values()->map(function ($c, $i) {
                            $huruf = chr(65 + $i);
                            $text = $c['choiceText'] ?? $c['label'] ?? "Pilihan " . ($i + 1);

                            return [
                                'huruf' => $huruf, 
                                'text'  => $text, 
                            ];
                        })->toArray(),
                        'questionType' => 'CHECKBOX',
                    ];
                })->toArray();
                break;


            default:
                $pertanyaan = collect($pertanyaan)->map(function ($p) {
                    $p['questionType'] = $p['questionType'] ?? 'RADIO';
                    return $p;
                })->toArray();
                break;
        }

        if (empty($pertanyaan)) {
            return redirect()->route('daftar-tes')->with('error', 'Gagal memuat pertanyaan.');
        }

        Session::put('assessment_id', $assessmentId);
        Session::put('nama_tes', $slug);
        Session::put('pertanyaan_tes', $pertanyaan);
        Session::forget('jawaban');
        Session::put('soal_sekarang', 1);

        if (!Session::has('waktu_mulai_tes')) {
            Session::put('waktu_mulai_tes', Carbon::now()->floorSecond());
            Session::put('durasi_tes', 1800);
        }

        return redirect()->route('tes.soal', ['slug' => $slug, 'nomor' => 1]);
    }


    public function tampilkanSoal($slug, $nomor)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $pertanyaanList = Session::get('pertanyaan_tes');

        if (!$pertanyaanList || !isset($pertanyaanList[$nomor - 1])) {
            return redirect()->route('daftar-tes')->with('error', 'Pertanyaan tidak ditemukan.');
        }

        $waktuMulai = Session::get('waktu_mulai_tes');
        $durasi = Session::get('durasi_tes', 1800);

        if (!$waktuMulai) {
            $waktuMulai = Carbon::now()->floorSecond();
            Session::put('waktu_mulai_tes', $waktuMulai);
        }


        $mulai = Carbon::parse($waktuMulai);
        $sekarang = Carbon::now();
        $elapsed = $mulai->diffInSeconds($sekarang);
        $sisaDetik = max(0, $durasi - $elapsed);


        if ($sisaDetik <= 0) {
            return redirect()->route('tes.selesaikan', ['slug' => $slug])
                            ->with('error', 'Waktu tes sudah habis.');
        }

        $pertanyaan = $pertanyaanList[$nomor - 1];
        $jawaban = Session::get('jawaban', []);

        return view('soal', compact('slug', 'nomor', 'pertanyaan', 'jawaban', 'sisaDetik', 'pertanyaanList'));
    }


    public function simpanJawaban(Request $request)
    {
        $slug = Session::get('nama_tes');
        $nomor = (int) $request->input('nomor');
        $jawaban = $request->input('jawaban');

        $pertanyaanList = Session::get('pertanyaan_tes', []);
        $pertanyaanSekarang = $pertanyaanList[$nomor - 1] ?? null;

        if ($pertanyaanSekarang) {
            $tipe = $pertanyaanSekarang['questionType'] ?? 'RADIO';

            if ($tipe === 'CHECKBOX') {
                Session::put("jawaban.$nomor", (array) $jawaban);
            } else {
                Session::put("jawaban.$nomor", $jawaban);
            }
        }

        $jumlahSoal = count($pertanyaanList);

        if ($request->has('sebelumnya')) {
            $nomor = max(1, $nomor - 1);
        } elseif ($request->has('selanjutnya')) {
            $nomor = min($jumlahSoal, $nomor + 1);
        } elseif ($request->has('selesai')) {
            return redirect()->route('tes.selesaikan', ['slug' => $slug]);
        }

        return redirect()->route('tes.soal', ['slug' => $slug, 'nomor' => $nomor]);
    }

    public function selesaikanTes($slug)
    {
        $jawaban = Session::get('jawaban', []);
        $studentId = Session::get('student_id');

        if (empty($jawaban)) {
            return redirect()->route('tes.soal', ['slug' => $slug, 'nomor' => 1])
                ->with('error', 'Kamu belum mengisi tes.');
        }

        switch ($slug) {
            case 'tes-mbti':
                $hasil = HasilTes::hitungMBTI($jawaban);
                break;
            case 'tes-preferensi-bakat':
                $hasil = HasilTes::hitungPreferensiBakat($jawaban);
                break;
            case 'tes-tipe-pekerjaan':
                $hasil = HasilTes::hitungTipeKerja($jawaban);
                break;
            default:
                return redirect()->route('tes.daftar')->with('error', 'Jenis tes tidak valid.');
        }

        HasilTes::simpanHasil($studentId, $slug, [
            'hasil_akhir' => $hasil['kategori_terbawah'] ?? $hasil['kategori_teratas'] ?? $hasil['tipe_teratas'],
            'detail_skor' => $hasil['skor'] ?? [],
            'jawaban' => $jawaban,
        ]);

        $nim = Session::get('student_nim');
        $assessmentId = Session::get('assessment_id');

        $prediksi = HasilTes::kirimUntukPrediksi($studentId, $nim, $assessmentId);

        if (!$prediksi) {
            return back()->with('error', 'Prediksi gagal.');
        }

        Session::put('prediksi', $prediksi);

        $mbti = HasilTes::where('student_id', $studentId)
                    ->where('tes_slug', 'tes-mbti')
                    ->latest()
                    ->first()
                    ->hasil_akhir ?? null;

        $careerid = data_get($prediksi, 'api response.data.id');
        $top3 = data_get($prediksi, 'top_3_riasec', []);
        $bottom2 = data_get($prediksi, 'bottom_2_mi', []);

        $rekomendasi = HasilTes::kirimUntukRekomendasi(
            $nim,
            $assessmentId,
            $careerid,
            $mbti,
            $top3,
            $bottom2
        );
        
        Session::forget(['jawaban', 'pertanyaan_tes', 'waktu_mulai_tes', 'durasi_tes', 'soal_sekarang', 'nama_tes', 'assessment_id', 'prediksi']);

        return redirect()->route('tes.hasil', ['slug' => $slug])
            ->with('success', 'Tes berhasil diselesaikan!');
    }
}