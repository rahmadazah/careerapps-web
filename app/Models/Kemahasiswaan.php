<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Helpers\FirebaseHelper;
use Carbon\Carbon;

class Kemahasiswaan
{
    protected $baseUrl = 'https://devskripsi.com/api/student/detail';
    protected string $baseFirestore = 'https://firestore.googleapis.com/v1/projects/career-apps/databases/(default)/documents/kegiatan-kemahasiswaan';

    public function dapatkanData()
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = Http::withToken($token)->get($this->baseUrl);
        if (!$response->successful()){
            return null;
        } 

        $data = $response->json()['data'];
        if (!empty($data['Organization'])) {
            foreach ($data['Organization'] as &$organisasi) {
                if (!empty($organisasi['dateStart'])) {
                    $organisasi['dateStart'] = Carbon::parse($organisasi['dateStart'])->translatedFormat('d F Y');
                }
                if (!empty($organisasi['dateEnd'])) {
                    $organisasi['dateEnd'] = Carbon::parse($organisasi['dateEnd'])->translatedFormat('d F Y');
                }
            }
        }

        if (!empty($data['Volunteer'])) {
            foreach ($data['Volunteer'] as &$kepanitiaan) {
                if (!empty($kepanitiaan['startDate'])) {
                    $kepanitiaan['startDate'] = Carbon::parse($kepanitiaan['startDate'])->translatedFormat('d F Y');
                }
                if (!empty($kepanitiaan['endDate'])) {
                    $kepanitiaan['endDate'] = Carbon::parse($kepanitiaan['endDate'])->translatedFormat('d F Y');
                }
            }
        }

        return [
            'Organization' => $data['Organization'] ?? [],
            'Volunteer' => $data['Volunteer'] ?? [],
            'Achievement' => $data['Achievement'] ?? [],
        ];
    }

    public function dapatkanOrganisasi()
    {
        $accessToken = FirebaseHelper::getAccessToken();
        $response = Http::withToken($accessToken)
            ->get("{$this->baseFirestore}/organisasi/filkom");

        $data = $response->json();

        if (!isset($data['documents'])) {
            return [];
        }

        $organisasi = [];

        foreach ($data['documents'] as $doc) {
            $fields = $doc['fields'];

            $softskills = [];
            if (isset($fields['softskill']['arrayValue']['values'])) {
                foreach ($fields['softskill']['arrayValue']['values'] as $skill) {
                    if (isset($skill['stringValue'])) {
                        $softskills[] = $skill['stringValue'];
                    }
                }
            }
            
            $organisasi[] = [
                'nama' => $fields['nama']['stringValue'] ?? '-',
                'deskripsi' => $fields['deskripsi']['stringValue'] ?? '',
                'url' => $fields['url']['stringValue'] ?? '-',
                'softskill' => $softskills, 
            ];
        }

        return $organisasi;
    }

    public function dapatkanKepanitiaan()
    {
        $accessToken = FirebaseHelper::getAccessToken();
        $response = Http::withToken($accessToken)
            ->get("{$this->baseFirestore}/kepanitiaan/filkom");

        $data = $response->json();

        if (!isset($data['documents'])) {
            return [];
        }

        $kepanitiaan = [];

        foreach ($data['documents'] as $doc) {
            $fields = $doc['fields'];
            $softskills = [];
            if (isset($fields['softskill']['arrayValue']['values'])) {
                foreach ($fields['softskill']['arrayValue']['values'] as $skill) {
                    if (isset($skill['stringValue'])) {
                        $softskills[] = $skill['stringValue'];
                    }
                }
            }

            $kepanitiaan[] = [
                'nama' => $fields['nama']['stringValue'] ?? '-',
                'deskripsi' => $fields['deskripsi']['stringValue'] ?? '',
                'url' => $fields['url']['stringValue'] ?? '-',
                'softskill' => $softskills,
            ];
        }

        return $kepanitiaan;
    }

    public function dapatkanLomba()
    {
        $accessToken = FirebaseHelper::getAccessToken();
        $response = Http::withToken($accessToken)->get("{$this->baseFirestore}/lomba/nasional");

        $data = $response->json();

        if (!isset($data['documents'])) {
            return [];
        }

        $lomba = [];

        foreach ($data['documents'] as $doc) {
            $fields = $doc['fields'];

            $lomba[] = [
                'nama' => $fields['nama']['stringValue'] ?? '-',
                'deskripsi' => $fields['deskripsi']['stringValue'] ?? '',
                'url' => $fields['url']['stringValue'] ?? '-',
            ];
        }

        return $lomba;
    }

    public function dapatkanAcak($list)
    {
        if (empty($list)) return null;
        $items = array_values($list);

        return $items[array_rand($items)];
    }
}
