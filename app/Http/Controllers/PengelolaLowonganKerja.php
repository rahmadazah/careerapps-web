<?php

namespace App\Http\Controllers;

use App\Models\LowonganKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengelolaLowonganKerja extends Controller
{
    protected $lowonganKerja;

    public function __construct(LowonganKerja $lowonganKerja)
    {
        $this->lowonganKerja = $lowonganKerja;
    }

    public function tampilkanSemua(Request $request)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('masuk')->with('error', 'Silakan login dulu.');
        }

        $status = $request->input('status');
        $search = $request->input('search');
        $page   = (int) $request->input('page', 1);
        $perPage = 10;

        $daftarLowonganKerja = $this->lowonganKerja->dapatkanSemua();

        if (!$daftarLowonganKerja) {
            return view('daftar-lowongan-kerja', [
                'daftarLowonganKerja' => [],
                'error' => 'Gagal mengambil data dari API.'
            ]);
        }

        $filtered = collect($daftarLowonganKerja)
            ->filter(function ($item) use ($status, $search) {

                if ($status && strtolower($item['status']) !== strtolower($status)) {
                    return false;
                }

                if ($search) {
                    $key = strtolower($search);
                    return str_contains(strtolower($item['title']), $key)
                        || str_contains(strtolower($item['companyName']), $key)
                        || str_contains(strtolower($item['location']), $key);
                }

                return true;
            })
            ->values();

        $total = $filtered->count();
        $totalPages = max(1, ceil($total / $perPage));
        $offset = ($page - 1) * $perPage;

        $paginatedData = $filtered->slice($offset, $perPage)->values();

        return view('daftar-lowongan-kerja', [
            'daftarLowonganKerja' => $paginatedData,
            'status' => $status,
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

        $lowonganKerja = $this->lowonganKerja->dapatkanBerdasarkanSlug($slug);

        if ($lowonganKerja) {
            return view('detail-kerja', compact('lowonganKerja'));
        }

        return redirect()->route('kerja')->with('error', 'Lowongan kerja tidak ditemukan.');
    }
}
