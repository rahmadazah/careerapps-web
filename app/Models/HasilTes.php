<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Helpers\FirebaseHelper;

class HasilTes extends Model
{
    protected $table = 'hasil_tes';

    protected $fillable = [
        'student_id',
        'tes_slug',
        'hasil_akhir',
        'detail_skor',
        'jawaban',
    ];

    protected $casts = [
        'detail_skor' => 'array',
        'jawaban' => 'array',
    ];

    protected static string $baseFirestore = 'https://firestore.googleapis.com/v1/projects/career-apps/databases/(default)/documents'; 
    protected static string $baseUrl = 'http://152.42.160.174:7000/api/student';

    public static function hitungMBTI(array $jawaban): array
    {
        $konfigurasiDimensi = [
            "E/I" => ["E", "I"],
            "N/S" => ["N", "S"],
            "F/T" => ["F", "T"],
            "J/P" => ["J", "P"],
        ];

        $jumlahDimensi = [
            "E" => 0, "I" => 0,
            "N" => 0, "S" => 0,
            "F" => 0, "T" => 0,
            "J" => 0, "P" => 0,
        ];

        $rentangDimensi = [
            ["E/I", range(1, 7)],  
            ["N/S", range(8, 14)], 
            ["F/T", range(15, 21)],
            ["J/P", range(22, 28)],
        ];

        foreach ($rentangDimensi as [$dimensi, $rentang]) {
            [$pilihanSatu, $pilihanDua] = $konfigurasiDimensi[$dimensi];

            foreach ($rentang as $index) {
                if (!isset($jawaban[$index])) continue;

                $label = strtoupper(trim($jawaban[$index]));

                if ($label === 'A') {
                    $jumlahDimensi[$pilihanSatu]++;
                } elseif ($label === 'B') {
                    $jumlahDimensi[$pilihanDua]++;
                }
            }
        }

        $tipeKepribadian = "";
        foreach (array_keys($konfigurasiDimensi) as $dimensi) {
            [$pilihanSatu, $pilihanDua] = $konfigurasiDimensi[$dimensi];
            $tipeKepribadian .= $jumlahDimensi[$pilihanSatu] >= $jumlahDimensi[$pilihanDua]
                ? $pilihanSatu
                : $pilihanDua;
        }

        return [
            "tipe_teratas" => $tipeKepribadian,
            "skor" => $jumlahDimensi,
        ];
    }


    public static function hitungPreferensiBakat(array $jawaban): array
    {
        $kategori = [
            'Kinestetik' => [1, 10, 19],
            'Eksistensial' => [2, 11, 20],
            'Interpersonal' => [3, 12, 21],
            'Intrapersonal' => [4, 13, 22],
            'Logika-Matematis' => [5, 14, 23],
            'Musikal' => [6, 15, 24],
            'Naturalistik' => [7, 16, 25],
            'Verbal/Linguistik' => [8, 17, 26],
            'Visual/Spasial' => [9, 18, 27],
        ];

        $nilaiKategori = array_fill_keys(array_keys($kategori), 0);

        foreach ($jawaban as $index => $value) {
            if (empty($value)) continue;

            $nomorSoal = $index + 1;

            foreach ($kategori as $namaKategori => $soalKategori) {
                if (in_array($nomorSoal, $soalKategori)) {
                    $jawabanDipilih = strtolower(trim($value));
                    if ($jawabanDipilih === 'a') $nilaiKategori[$namaKategori] += 1;
                    elseif ($jawabanDipilih === 'b') $nilaiKategori[$namaKategori] += 2;
                    elseif ($jawabanDipilih === 'c') $nilaiKategori[$namaKategori] += 3;
                    break;
                }
            }
        }

        arsort($nilaiKategori);

        $kategoriTerbawah = array_slice(array_keys($nilaiKategori), -2, 2, true);
        $hasil = implode(', ', $kategoriTerbawah);

        return [
            'kategori_terbawah' => $hasil,
            'skor' => $nilaiKategori,
        ];
    }


    public static function hitungTipeKerja(array $jawaban): array
    {
        $kategori = [
            'Realistic' => [1, 2, 13, 14, 25, 26],
            'Investigative' => [3, 4, 15, 16, 27, 28],
            'Artistic' => [5, 6, 17, 18, 29, 30],
            'Social' => [7, 8, 19, 20, 31, 32],
            'Enterprising' => [9, 10, 21, 22, 33, 34],
            'Conventional' => [11, 12, 23, 24, 35, 36],
        ];

        $nilaiKategori = array_fill_keys(array_keys($kategori), 0);

        foreach ($jawaban as $index => $value) {
            if (empty($value)) continue;

            $nomorSoal = $index; 
            if (!is_array($value)) {
                $value = [$value];
            }

            foreach ($kategori as $namaKategori => $soalKategori) {
                if (in_array($nomorSoal, $soalKategori)) {
                    $nilaiKategori[$namaKategori] += count($value);
                    break;
                }
            }
        }

        arsort($nilaiKategori);

        $kategoriTeratas = array_slice(array_keys($nilaiKategori), 0, 3);
        $hasil = implode(', ', $kategoriTeratas);

        return [
            'kategori_teratas' => $hasil,
            'skor' => $nilaiKategori,
        ];
    }


    public static function simpanHasil($studentId, $slug, $hasil)
    {
        return self::create([
            'student_id'   => $studentId,
            'tes_slug'     => $slug,
            'hasil_akhir'  => $hasil['hasil_akhir'],
            'detail_skor'  => ($hasil['detail_skor']),
            'jawaban'      => ($hasil['jawaban']),
        ]); 
    }

    public static function dapatkanHasilTes()
    {
        $studentId = Session::get('student_id');

        if (!$studentId) {
            return [
                'mbti' => null,
                'preferensiBakat' => null,
                'tipePekerjaan' => null,
            ];
        }

        $mbti = self::where('student_id', $studentId)
            ->where('tes_slug', 'tes-mbti')
            ->latest()
            ->value('hasil_akhir');

        $preferensi = self::where('student_id', $studentId)
            ->where('tes_slug', 'tes-preferensi-bakat')
            ->latest()
            ->first();

        $preferensiBakat = null;
        if ($preferensi && is_array($preferensi->detail_skor)) {
            $minValue = min($preferensi->detail_skor);
            $preferensiBakat = array_search($minValue, $preferensi->detail_skor);
        }

        $tipe = self::where('student_id', $studentId)
            ->where('tes_slug', 'tes-tipe-pekerjaan')
            ->latest()
            ->first();

        $tipePekerjaan = null;
        if ($tipe && is_array($tipe->detail_skor)) {
            $maxValue = max($tipe->detail_skor);
            $tipePekerjaan = array_search($maxValue, $tipe->detail_skor);
        }

        return [
            'mbti' => $mbti,
            'preferensiBakat' => $preferensiBakat,
            'tipePekerjaan' => $tipePekerjaan,
        ];
    }

    public static function dapatkanSemuaSkor($slug)
    {
        $studentId = Session::get('student_id');
        if (!$studentId) return null;

        $record = self::where('student_id', $studentId)
            ->where('tes_slug', $slug)
            ->latest()
            ->first();

        if (!$record) return null;

        return $record->detail_skor;
    }

    
    public static function dapatkanSkorUtama($slug, $hasilAkhir)
    {
        $semuaSkor = self::dapatkanSemuaSkor($slug);
        if (!$semuaSkor) return null;

        return $semuaSkor[$hasilAkhir] ?? null;
    }

    public static function dapatkanPenjelasanHasil($slug, $hasilAkhir)
    {
        $all = self::dapatkanSemuaPenjelasan($slug);

        if (!$all || !$hasilAkhir) {
            return null;
        }

        $key = strtolower(
            str_replace([' ', '/', '_'], '-', trim($hasilAkhir))
        );

        return $all[$key] ?? null;
    }

    public static function dapatkanSemuaPenjelasan($slug)
    {
        $map = [
            'tes-mbti' => 'mbti',
            'tes-preferensi-bakat' => 'pref-bakat',
            'tes-tipe-pekerjaan' => 'tipe-pekerjaan',
        ];

        if (!isset($map[$slug])) {
            return null;
        }

        $document = $map[$slug];

        $accessToken = FirebaseHelper::getAccessToken();
        $firebaseURL = self::$baseFirestore . "/detail-tes/{$document}";
        $response = Http::withToken($accessToken)->get($firebaseURL);

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        if (isset($data['fields'])) {
            $parsed = [];

            foreach ($data['fields'] as $key => $value) {
                $parsed[strtolower($key)] = reset($value);
            }

            return $parsed;
        }

        return $data;
    }


    public static function kirimUntukPrediksi(string $studentId, string $nim, string $assessmentId)
    {
        $hasilPreferensi = self::where('student_id', $studentId)
            ->where('tes_slug', 'tes-preferensi-bakat')
            ->latest()
            ->first();

        $hasilTipeKerja = self::where('student_id', $studentId)
            ->where('tes_slug', 'tes-tipe-pekerjaan')
            ->latest()
            ->first();

        if (!$hasilPreferensi || !$hasilTipeKerja) {
            return null;
        }

        $mapPreferensi = [
            "Musikal"         => "testReferensiBakatMusikal",
            "Logika-Matematis"=> "testReferensiBakatLogikaMatematis",
            "Verbal/Linguistik"=> "testReferensiBakatVerbalLinguistik",
            "Eksistensial"    => "testReferensiBakatEksistensial",
            "Interpersonal"   => "testReferensiBakatInterpersonal",
            "Intrapersonal"   => "testReferensiBakatIntrapersonal",
            "Naturalistik"    => "testReferensiBakatNaturalistik",
            "Kinestetik"      => "testReferensiBakatKinestetik",
            "Visual/Spasial"  => "testReferensiBakatVisualSpasial",
        ];

        $mapTipeKerja = [
            "Realistic"     => "testTipePekerjaanRealistic",
            "Investigative" => "testTipePekerjaanInvestigative",
            "Artistic"      => "testTipePekerjaanArtistic",
            "Social"        => "testTipePekerjaanSocial",
            "Enterprising"  => "testTipePekerjaanEnterprising",
            "Conventional"  => "testTipePekerjaanConventional",
        ];

        $payload = [
            'nim' => $nim,
            'testID' => $assessmentId,
        ];

        foreach ($hasilPreferensi->detail_skor as $kategori => $nilai) {
            if (isset($mapPreferensi[$kategori])) {
                $payload[$mapPreferensi[$kategori]] = $nilai;
            }
        }

        foreach ($hasilTipeKerja->detail_skor as $kategori => $nilai) {
            if (isset($mapTipeKerja[$kategori])) {
                $payload[$mapTipeKerja[$kategori]] = $nilai;
            }
        }

        $response = Http::timeout(20)
            ->asJson()           
            ->post('http://152.42.160.174:8888/v3/prediction', $payload);

    
        return $response->json();
    }

    public static function kirimUntukRekomendasi(
        string $nim,
        string $assessmentId,
        string $careerId,
        string $mbti,
        array $top3,
        array $bottom2
    ) {
        $payload = [
            'nim' => $nim,
            'testID' => $assessmentId,
            'careerID' => $careerId,
            'testMBTI' => $mbti,
            'testPotential1' => $bottom2[0][0] ?? null,
            'testPotential2' => $bottom2[1][0] ?? null,
            'testJobType1' => $top3[0][0] ?? null,
            'testJobType2' => $top3[1][0] ?? null,
            'testJobType3' => $top3[2][0] ?? null,
        ];

        $response = Http::post('http://152.42.160.174:8888/v3/recommendation', $payload);

        return $response->json();
    }

    public static function mappingMBTI($kode)
    {
        if (!$kode) return null;

        $map = [
            'E' => 'Extrovert',
            'I' => 'Introvert',
            'S' => 'Sensing',
            'N' => 'Intuitive',
            'T' => 'Thinking',
            'F' => 'Feeling',
            'J' => 'Judging',
            'P' => 'Perceiving',
        ];

        return collect(str_split($kode))
            ->map(fn($c) => $map[$c] ?? $c)
            ->toArray();
    }

}