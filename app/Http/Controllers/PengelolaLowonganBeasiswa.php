<?php

namespace App\Http\Controllers;

use App\Models\LowonganBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengelolaLowonganBeasiswa extends Controller
{
    protected $lowonganBeasiswa;

    public function __construct(LowonganBeasiswa $lowonganBeasiswa)
    {
        $this->lowonganBeasiswa = $lowonganBeasiswa;
    }

    public function tampilkanSemua(Request $request)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $search = $request->input('search');
        $page   = (int) $request->input('page', 1);
        $perPage = 10;

        $daftarLowonganBeasiswa = $this->lowonganBeasiswa->dapatkanSemua();

        if (!$daftarLowonganBeasiswa) {
            return view('daftar-lowongan-beasiswa', [
                'daftarLowonganBeasiswa' => collect(),
                'search' => $search ?? '',
                'currentPage' => 1,
                'totalPages' => 1,
            ]);
        }

        $filtered = collect($daftarLowonganBeasiswa)
            ->filter(function ($item) use ($search) {

                if ($search) {
                    $key = strtolower($search);

                    return str_contains(strtolower($item['title']), $key)
                        || str_contains(strtolower($item['organizer']), $key);
                }

                return true;
            })
            ->values();

        $total = $filtered->count();
        $totalPages = max(1, ceil($total / $perPage));
        $offset = ($page - 1) * $perPage;

        $paginatedData = $filtered->slice($offset, $perPage)->values();

        return view('daftar-lowongan-beasiswa', [
            'daftarLowonganBeasiswa' => $paginatedData,
            'search' => $search ?? '',
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }


    public function tampilkanDetail($slug)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $lowonganBeasiswa = $this->lowonganBeasiswa->dapatkanBerdasarkanSlug($slug);

        if ($lowonganBeasiswa) {
            return view('detail-beasiswa', compact('lowonganBeasiswa'));
        }

        return redirect()->route('beasiswa')->with('error', 'Beasiswa tidak ditemukan.');
    }
}
