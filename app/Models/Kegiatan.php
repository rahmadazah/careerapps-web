<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services\BaseApiService;
use Carbon\Carbon;

class Kegiatan extends BaseApiService
{
    // protected $baseUrl = 'https://devskripsi.com/api/student/activity';

    public function dapatkanSemua()
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = $this->get('/student/activity');
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

            $response = $this->get('/student/activity/'. $id);
            if (!$response || !$response->successful()) {
                return null;
            }
        // $response = Http::withToken($token)->get("{$this->baseUrl}/{$id}");

        if ($response->successful()) {
            $data = $response->json()['data'];

            $data['createdAt'] = Carbon::parse($data['createdAt'])->translatedFormat('d F Y');
            $data['date'] = Carbon::parse($data['date'])->translatedFormat('d F Y');
            $data['detail'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['detail']);
            $data['about'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['about']);

            return $data;
        }

        return null;
    }

    public function dapatkanBerdasarkanSlug($slug)
    {
        $daftarKegiatan = $this->dapatkanSemua();

        if (!$daftarKegiatan) return null;

        foreach ($daftarKegiatan as $item) {
            if ($item['slug'] === $slug) {
                return $this->dapatkanBerdasarkanId($item['id']);
            }
        }

        return null;
    }
}
