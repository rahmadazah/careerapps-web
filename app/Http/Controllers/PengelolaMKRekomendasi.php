<?php

namespace App\Http\Controllers;

use App\Helpers\FirebaseHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PengelolaMKRekomendasi extends Controller
{
    public function detail($slug)
    {
        $token = Session::get('api_token');
        if (!$token) return redirect()->route('masuk')->with('error', 'Silakan login dulu.');

        $responseKarier = Http::withToken($token)->get('https://devskripsi.com/api/student/career');
        $dataKarier = collect($responseKarier->json()['data'] ?? []);
        $rekomendasiKarier = $dataKarier->first()['careerPrediction'] ?? null;
        
        $accessToken = FirebaseHelper::getAccessToken();

        $stream = $this->mapCareerToStream($rekomendasiKarier);
        $firebaseURL = "https://firestore.googleapis.com/v1/projects/career-apps/databases/(default)/documents/{$stream}/{$slug}";
        $response = Http::withToken($accessToken)->get($firebaseURL);
        

        if (!$response->successful()) return abort(404, 'Data mata kuliah tidak ditemukan.');

        $data = $response->json()['fields'];

        return view('mk-rekomendasi', [
            'nama' => $data['nama-matkul']['stringValue'] ?? '-',
            'slug' => Str::slug($fields['nama-matkul']['stringValue'] ?? ''),
            'deskripsi' => $data['deskripsi-matkul']['stringValue'] ?? '',
            'cpmk' => $data['cpmk']['stringValue'] ?? '',
            'subcpmk' => $data['sub-cpmk']['stringValue'] ?? '',
            'kode' => $data['kode-matkul']['stringValue'] ?? '-',
            'sks' => $data['jumlah-sks']['integerValue'] ?? '0',
            'prasyarat' => $data['prasyarat-matkul']['stringValue'] ?? '-',
        ]);
    }

    private function mapCareerToStream($career)
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