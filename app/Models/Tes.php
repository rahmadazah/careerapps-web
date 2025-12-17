<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services\BaseApiService;
use App\Helpers\FirebaseHelper;

class Tes extends BaseApiService
{
    // protected string $baseUrl = 'https://devskripsi.com/api/student/assessment';

    public function dapatkanSemua()
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = $this->get('/student/assessment');
        if (!$response || !$response->successful()) {
            return null;
        }

        if ($response->successful()) {
            $data = $response->json()['data'];

            foreach ($data as &$item) {
                $item['slug'] = Str::slug($item['title']);
            }
            return $data;
        }

        return [];
    }

    public function dapatkanBerdasarkanSlug($slug)
    {
        $daftarTes = $this->dapatkanSemua();

        if (!$daftarTes) return null;

        foreach ($daftarTes as $item) {
            if ($item['slug'] === $slug) {
                return $this->dapatkanBerdasarkanId($item['id']);
            }
        }

        return null;
    }

    public function dapatkanBerdasarkanId($id)
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = $this->get('/student/assessment/'. $id);
        if (!$response || !$response->successful()) {
            return null;
        }

        if ($response->successful()) {
            $data = $response->json()['data'];
            return $data;
        }

        return null;
    }

    public function dapatkanPersetujuanPengguna($slug)
    {
        $tesModel = new self();
        $tes = $tesModel->dapatkanBerdasarkanSlug($slug);

        if (!$tes) {
            return null;
        }

        $persetujuanPengguna = $tes['UserAgreements'] ?? null;

        if ($persetujuanPengguna && isset($persetujuanPengguna['detail'])) {
            $persetujuanPengguna['detail'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $persetujuanPengguna['detail']);
        }

        return [
            'tes' => $tes,
            'persetujuanPengguna' => $persetujuanPengguna,
        ];
    }

    public static function dapatkanPertanyaan($assessmentId, $token)
    {
        // $response = Http::withToken($token)->get("https://devskripsi.com/api/student/assessment/{$assessmentId}/question");

        $response = Http::withToken($token)
        ->get(config('services.api.base_url') . '/student/assessment/' . $assessmentId . '/question');

        if (!$response || !$response->successful()) {
            return null;
        }

        if (!$response->successful()) {
            return [];
        }

        return $response->json()['data'];
    }
}
