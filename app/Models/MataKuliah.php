<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Helpers\FirebaseHelper;

class MataKuliah
{
    protected string $baseUrl = 'https://devskripsi.com/api/student';
    protected string $baseFirestore = 'https://firestore.googleapis.com/v1/projects/career-apps/databases/(default)/documents';

    public function dapatkanMKRelevan()
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->baseUrl}/detail");

        if (!$response->successful()) {
            return collect();
        }

        $data = $response->json()['data'];
        $dataAkademik = $data['Academic'][0] ?? null;

        if (!$dataAkademik || !isset($dataAkademik['KRS'])) {
            return collect();
        }

        $mataKuliahDiambil = collect();

        foreach ($dataAkademik['KRS'] as $krs) {
            foreach ($krs['CourseTaken'] ?? [] as $item) {
                $course = $item['course'] ?? [];
                if (isset($course['code'])) {
                    $mataKuliahDiambil->push([
                        'kode' => $course['code'],
                        'nama' => $course['name'] ?? '-',
                        'slug' => Str::slug($course['name']),
                        'sks' => $course['sks'] ?? null,
                        'dosen' => $item['lecturer'] ?? '-',
                        'nilai' => strtoupper(str_replace(['_plus', '_minus'], ['+', '-'], $item['grade'] ?? '-')),
                    ]);
                }
            }
        }

        return $mataKuliahDiambil->unique('kode')->values();
    }

    public function dapatkanDetailMKRelevan($slug)
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $responseDetail = Http::withToken($token)->get("{$this->baseUrl}/detail");
       
        if (!$responseDetail->successful()) return null;

        $krsData = $responseDetail->json()['data']['Academic'][0]['KRS'] ?? [];

        $foundMK = collect($krsData)->flatMap(fn($krs) => $krs['CourseTaken'] ?? [])
            ->map(fn($item) => [
                'slug' => Str::slug($item['course']['name'] ?? ''),
                'name' => $item['course']['name'] ?? '-',
                'grade' => strtoupper(str_replace(['_plus', '_minus'], ['+', '-'], $item['grade'] ?? '-'))
            ])
            ->firstWhere('slug', $slug);

        if (!$foundMK) return null;

        $namaMK = $foundMK['name'];
        $grade = $foundMK['grade'];

        $responseKarier = Http::withToken($token)->get("{$this->baseUrl}/career");
        $dataKarier = collect($responseKarier->json()['data'] ?? []);
        $rekomendasiKarier = $dataKarier->first()['careerPrediction'] ?? null;

        $accessToken = FirebaseHelper::getAccessToken();

        $firebaseURL = "{$this->baseFirestore}/mata-kuliah/kurikulum-2020/tif-2020-wajib/{$slug}";
        $response = Http::withToken($accessToken)->get($firebaseURL);

        if (!$response->successful()) {
            $stream = $this->pemetaanMK($rekomendasiKarier);
            $firebaseURL = "{$this->baseFirestore}/{$stream}/{$slug}";
            $response = Http::withToken($accessToken)->get($firebaseURL);
        }

        if (!$response->successful()) return null;

        $fields = $response->json()['fields'] ?? [];

        return [
            'nama' => $namaMK,
            'grade' => $grade,
            'deskripsi' => $fields['deskripsi-matkul']['stringValue'] ?? '',
            'cpmk' => $fields['cpmk']['stringValue'] ?? '',
            'subcpmk' => $fields['sub-cpmk']['stringValue'] ?? '',
        ];
    }

    public function dapatkanMKRekomendasi()
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->baseUrl}/career");
        
        $dataKarier = collect($response->json()['data'] ?? []);
        $karier = $dataKarier->first()['careerPrediction'] ?? null;
        
        $streamPath = $this->pemetaanMK($karier);
        
        $accessToken = FirebaseHelper::getAccessToken();
        $response = Http::withToken($accessToken)->get("{$this->baseFirestore}/{$streamPath}");

        $documents = $response->json()['documents'] ?? [];

        return collect($documents)->map(function ($doc) {
            $fields = $doc['fields'] ?? [];
            
            $docId = basename($doc['name']);
            return [
                'nama' => $fields['nama-matkul']['stringValue'] ?? '-',
                'slug' => $docId,
                'kode' => $fields['kode-matkul']['stringValue'] ?? '-',
                'sks' => $fields['jumlah-sks']['integerValue'] ?? 0,
            ];
        });
    }

    public function dapatkanDetailMKRekomendasi($slug)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->baseUrl}/career");

        $dataKarier = collect($response->json()['data'] ?? []);
        $karier = $dataKarier->first()['careerPrediction'] ?? null;

        $streamPath = $this->pemetaanMK($karier);
        $accessToken = FirebaseHelper::getAccessToken();

        $url = "{$this->baseFirestore}/{$streamPath}/{$slug}";
        $response = Http::withToken($accessToken)->get($url);

        if (!$response->successful()) return null;

        $fields = $response->json()['fields'] ?? [];

        $detail = [
            'nama' => $fields['nama-matkul']['stringValue'] ?? '-',
            'slug' => $slug,
            'deskripsi' => $fields['deskripsi-matkul']['stringValue'] ?? '',
            'kode' => $fields['kode-matkul']['stringValue'] ?? '-',
            'sks' => $fields['jumlah-sks']['integerValue'] ?? 0,
            'prasyarat' => $fields['prasyarat-matkul']['stringValue'] ?? '-',
        ];

        $cpmkText = $fields['cpmk']['stringValue'] ?? '';
        $subCpmkText = $fields['sub-cpmk']['stringValue'] ?? '';

        $detail['cpmk'] = preg_split('/\d+\.\s*/', $cpmkText, -1, PREG_SPLIT_NO_EMPTY);
        $detail['subcpmk'] = preg_split('/\d+\.\s*/', $subCpmkText, -1, PREG_SPLIT_NO_EMPTY);

        return $detail;
    }

    public function pemetaanMK($career)
    {
        return match ($career) {
            'Backend Developer', 'Front-End Developer', 'System Analyst', 'Software Developer', 'Web Developer', 'QA Automation Engineer', 'QA Engineer', 'Product Manager', 'Project Manager', 'Software Engineer', 'Software QA Engineer', 'QA Analyst', 'QA Tester' 
                => 'mata-kuliah/kurikulum-2020/tif-2020-fullstack',

            'Cybersecurity Manager', 'Cybersecurity Analyst' 
                => 'mata-kuliah/kurikulum-2020/tif-2020-cs',

            'Data Scientist', 'Data Analyst' 
                => 'mata-kuliah/kurikulum-2020/tif-2020-ds',

            'Web Content Manager', 'UX Designer', 'Content Strategist', 'Web Content Writer', 'UI/UX Designer', 'Game Designer', 'Multimedia Artist', 'Human Computer Interaction (HCI) Specialist' 
                => 'mata-kuliah/kurikulum-2020/tif-2020-im',

            'Network Architect', 'Technical Consultant', 'Technical Support', 'Network Administrator', 'Tech Support Specialist', 'System Administrator', 'Computer Hardware Engineer' 
                => 'mata-kuliah/kurikulum-2020/tif-2020-jaringan',

            'Business Development Manager', 'Digital Marketer', 'Business Analyst', 'Technical Writer', 'IT Trainer', 'Tech Recruiter', 'Chief Marketing Officer', 'IT Consultant' 
                => 'mata-kuliah/kurikulum-2020/tif-2020-nonstream',

            'Database Administrator' 
                => 'mata-kuliah/kurikulum-2020/tif-2020-kc',

            default 
                => 'mata-kuliah/kurikulum-2020/tif-2020-nonstream',
        };
    }
}
