<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LowonganBeasiswa
{
    protected $baseUrl = 'https://devskripsi.com/api/student/scholarship';

    public function dapatkanSemua()
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = Http::withToken($token)->get($this->baseUrl);

        if ($response->successful()) {
            $data = $response->json()['data'];

            foreach ($data as &$item) {
                $item['slug'] = Str::slug($item['title']);
                $item['createdAt'] = Carbon::parse($item['createdAt'])->translatedFormat('d F Y');
                $item['start_period_date'] = Carbon::parse($item['start_period_date'])->translatedFormat('d F Y');
                $item['end_period_date'] = Carbon::parse($item['end_period_date'])->translatedFormat('d F Y');
            }

            return $data;
        }

        return [];
    }

    public function dapatkanBerdasarkanId($id)
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = Http::withToken($token)->get("{$this->baseUrl}/{$id}");

        if ($response->successful()) {
            $data = $response->json()['data'];

            $data['createdAt'] = Carbon::parse($data['createdAt'])->translatedFormat('d F Y');
            $data['start_period_date'] = Carbon::parse($data['start_period_date'])->translatedFormat('d F Y');
            $data['end_period_date'] = Carbon::parse($data['end_period_date'])->translatedFormat('d F Y');
            $data['description'] = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $data['description']);

            return $data;
        }

        return null;
    }

    public function dapatkanBerdasarkanSlug($slug)
    {
        $daftarBeasiswa = $this->dapatkanSemua();

        if (!$daftarBeasiswa) return null;

        foreach ($daftarBeasiswa as $item) {
            if ($item['slug'] === $slug) {
                return $this->dapatkanBerdasarkanId($item['id']);
            }
        }

        return null;
    }
}
