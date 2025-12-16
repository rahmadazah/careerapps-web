@extends('layouts.app')

@section('title', 'Lowongan Magang')

@section('content')
    <h1 class="w-full text-black text-3xl font-bold leading-tight">Lowongan Magang</h1>
    <div class="w-full flex flex-col md:flex-row justify-between items-center gap-3">
        <div class="flex gap-2 text-sm items-center flex-wrap">
            <span class="text-[#073B60]">Filter</span>
            <a href="{{ route('magang') }}"
                class="p-2 rounded-lg {{ $filterRemote === null ? 'bg-[#1080CF] text-white' : 'bg-white text-[#777] border border-[#777]' }}">
                Terbaru
            </a>
            <a href="{{ route('magang', ['remote' => 'true', 'search' => request('search')]) }}"
                class="p-2 rounded-lg {{ $filterRemote === 'true' ? 'bg-[#1080CF] text-white' : 'bg-white text-[#777] border border-[#777]' }}">
                Remote
            </a>
        </div>
        
        <form method="GET" class="flex items-center gap-2 text-sm">
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Masukkan kata kunci"
                class="p-2 px-3 border border-[#777] text-[#777] rounded-lg focus:outline-none focus:border-[#1080CF]"/>

            @if ($filterRemote)
                <input type="hidden" name="remote" value="{{ $filterRemote }}">
            @endif

            <button class="p-2 px-3 bg-[#1080CF] text-white rounded-lg">
                Cari
            </button>
        </form>
    </div>

    @if ($daftarLowonganMagang->isEmpty())
        <p class="flex justify-center items-center w-full h-full text-center text-gray-500">
            Belum ada lowongan magang yang tersedia.
        </p>
    @else

    <ul class="w-full flex flex-col gap-4">
        @foreach ($daftarLowonganMagang as $lowonganMagang)
            <li>
                <a href="{{ route('magang.detail', $lowonganMagang['slug']) }}" class="w-full p-4 bg-white rounded-xl border border-[#E2E2E2] flex flex-row items-center gap-5">
                    <div class="w-20 h-20 overflow-hidden flex items-center justify-center">
                        <img class="max-w-full max-h-full object-contain" src="{{ $lowonganMagang['icon'] }}"/>
                    </div>
                    <div class="flex flex-col items-start rounded gap-1">
                        <div class="w-full text-xl font-bold">{{ $lowonganMagang['title'] }}</div>
                        <div class="w-full text-base font-medium">{{ $lowonganMagang['company'] }}</div>
                        <div class="w-full h-4 overflow-hidden flex items-center gap-1">
                            <svg width="10" height="11" viewBox="0 0 10 11" fill="none">
                                <path d="M5.00036 1.33334C3.16244 1.33334 1.66703 2.82876 1.66703 4.66459C1.65494 7.35001 4.87369 9.57668 5.00036 9.66668C5.00036 9.66668 8.34578 7.35001 8.33369 4.66668C8.33369 2.82876 6.83828 1.33334 5.00036 1.33334ZM5.00036 6.33334C4.07953 6.33334 3.33369 5.58751 3.33369 4.66668C3.33369 3.74584 4.07953 3.00001 5.00036 3.00001C5.92119 3.00001 6.66703 3.74584 6.66703 4.66668C6.66703 5.58751 5.92119 6.33334 5.00036 6.33334Z" fill="#073B60"/>
                            </svg>
                            <div class="text-[#073B60] text-xs font-normal">{{ $lowonganMagang['location'] }}</div>
                        </div>
                        <div class="w-full text-[#777] text-xs font-normal">{{ $lowonganMagang['createdAt'] }}</div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="w-full flex items-center justify-center gap-2 select-none">
        @if ($currentPage > 1)
            <a href="?page={{ $currentPage - 1 }}&remote={{ $filterRemote }}&search={{ $search }}"
                class="w-8 h-8 bg-white border rounded-xl shadow-sm hover:bg-blue-50 transition text-gray-600 flex justify-center items-center gap-1">
                <
            </a>
        @endif

        @for ($i = 1; $i <= $totalPages; $i++)
            <a href="?page={{ $i }}&remote={{ $filterRemote }}&search={{ $search }}"
                class="w-8 h-8 flex items-center justify-center rounded-xl
                       {{ $i == $currentPage 
                            ? 'bg-blue-600 text-white shadow-md scale-[1.05]' 
                            : 'bg-white text-gray-600 border hover:bg-blue-50' }}
                       transition">
                {{ $i }}
            </a>
        @endfor

        @if ($currentPage < $totalPages)
            <a href="?page={{ $currentPage + 1 }}&remote={{ $filterRemote }}&search={{ $search }}"
                class="w-8 h-8 bg-white border rounded-xl shadow-sm hover:bg-blue-50 transition text-gray-600 flex justify-center items-center gap-1">
                >
            </a>
        @endif

    </div>
    @endif
    
@endsection