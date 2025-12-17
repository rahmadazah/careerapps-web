<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services\BaseApiService;
use Carbon\Carbon;

class LowonganKerja extends BaseApiService
{
    // protected $baseUrl = 'https://devskripsi.com/api/student/job';

    public function dapatkanSemua()
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = $this->get('/student/job');
        if (!$response || !$response->successful()) {
            return null;
        }

        if ($response->successful()) {
            $data = $response->json()['data'];

            foreach ($data as &$item) {
                $item['slug'] = Str::slug($item['title']);
                $item['createdAt'] = Carbon::parse($item['createdAt'])->translatedFormat('d F Y');
            }

            return $data;
        }

        return [];
    }

    public function dapatkanBerdasarkanId($id)
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = $this->get('/student/job' . $id);
        if (!$response || !$response->successful()) {
            return null;
        }

        if ($response->successful()) {
            $data = $response->json()['data'];

            $data['createdAt'] = Carbon::parse($data['createdAt'])->translatedFormat('d F Y');
            $data['descriptions'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['descriptions']);
            $data['responsibilities'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['responsibilities']);
            $data['requirements'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['requirements']);
            $data['experiences'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['experiences']);
            $data['benefits'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['benefits']);

            return $data;
        }

        return null;
    }

    public function dapatkanBerdasarkanSlug($slug)
    {
        $daftarKerja = $this->dapatkanSemua();

        if (!$daftarKerja) return null;

        foreach ($daftarKerja as $item) {
            if ($item['slug'] === $slug) {
                return $this->dapatkanBerdasarkanId($item['id']);
            }
        }

        return null;
    }
}
