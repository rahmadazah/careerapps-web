<?php

namespace App\Http\Controllers;

use App\Models\LowonganMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengelolaLowonganMagang extends Controller
{
    protected $lowonganMagang;

    public function __construct(LowonganMagang $lowonganMagang)
    {
        $this->lowonganMagang = $lowonganMagang;
    }

    public function tampilkanSemua(Request $request)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $filterRemote = $request->input('remote');
        $search = $request->input('search');
        $page   = (int) $request->input('page', 1);
        $perPage = 10;

        $daftarLowonganMagang = $this->lowonganMagang->dapatkanSemua();

        if (!$daftarLowonganMagang) {
            return view('daftar-lowongan-magang', [
                'daftarLowonganMagang' => collect(),
                'filterRemote' => $filterRemote,
                'search' => $search ?? '',
                'currentPage' => 1,
                'totalPages' => 1
            ]);
        }

        $filtered = collect($daftarLowonganMagang)
            ->filter(function ($item) use ($filterRemote, $search) {

                if (!is_null($filterRemote)) {
                    if (
                        filter_var($item['remote'], FILTER_VALIDATE_BOOLEAN)
                        !== filter_var($filterRemote, FILTER_VALIDATE_BOOLEAN)
                    ) {
                        return false;
                    }
                }

                if ($search) {
                    $key = strtolower($search);

                    return str_contains(strtolower($item['title']), $key)
                        || str_contains(strtolower($item['company']), $key)
                        || str_contains(strtolower($item['location']), $key);
                }

                return true;
            })
            ->values();

        $total = $filtered->count();
        $totalPages = max(1, ceil($total / $perPage));
        $offset = ($page - 1) * $perPage;

        $paginatedData = $filtered->slice($offset, $perPage)->values();

        return view('daftar-lowongan-magang', [
            'daftarLowonganMagang' => $paginatedData,
            'filterRemote' => $filterRemote,
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

        $lowonganMagang = $this->lowonganMagang->dapatkanBerdasarkanSlug($slug);

        if ($lowonganMagang) {
            return view('detail-magang', compact('lowonganMagang'));
        }

        return redirect()->route('magang')->with('error', 'Lowongan magang tidak ditemukan.');
    }
}
