<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengelolaKegiatan extends Controller
{
    protected $kegiatan;

    public function __construct(Kegiatan $kegiatan)
    {
        $this->kegiatan = $kegiatan;
    }

    public function tampilkanSemua(Request $request)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $filterType  = $request->input('type');
        $search  = $request->input('search');
        $page    = (int) $request->input('page', 1);
        $perPage = 2;

        $daftarKegiatan = $this->kegiatan->dapatkanSemua();

        if (!$daftarKegiatan) {
            return view('daftar-kegiatan', [
                'daftarKegiatan' => collect(),
                'filterType' => $filterType,
                'search' => $search ?? '',
                'currentPage' => 1,
                'totalPages' => 1
            ]);
        }

        $filtered = collect($daftarKegiatan)
            ->filter(function ($item) use ($filterType, $search) {

                if ($filterType && strtolower($item['type']) !== strtolower($filterType)) {
                    return false;
                }

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

        return view('daftar-kegiatan', [
            'daftarKegiatan' => $paginatedData,
            'filterType' => $filterType,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function tampilkanDetail($slug)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $kegiatan = $this->kegiatan->dapatkanBerdasarkanSlug($slug);

        if ($kegiatan) {
            return view('detail-kegiatan', compact('kegiatan'));
        }

        return redirect()->route('kegiatan')->with('error', 'Kegiatan tidak ditemukan.');
    }
}
