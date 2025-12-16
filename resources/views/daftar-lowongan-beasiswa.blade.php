@extends('layouts.app')

@section('title', 'Lowongan Beasiswa')

@section('content')
    <h1 class="w-full text-black text-3xl font-bold leading-tight">Lowongan Beasiswa</h1>
    <div class="w-full flex flex-col md:flex-row justify-between items-center gap-3">
        <div class="flex gap-2 text-sm items-center flex-wrap">
            <span class="text-[#073B60]">Filter</span>
            <a href="{{ route('beasiswa') }}"
                class="p-2 rounded-lg bg-[#1080CF] text-white">
                Terbaru
            </a>
        </div>

        <form method="GET" class="flex items-center gap-2 text-sm">
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Masukkan kata kunci"
                class="p-2 px-3 border border-[#777] text-[#777] rounded-lg focus:outline-none focus:border-[#1080CF]"/>

            <button class="p-2 px-3 bg-[#1080CF] text-white rounded-lg">
                Cari
            </button>
        </form>
    </div>
    
    @if ($daftarLowonganBeasiswa->isEmpty())
        <p class="flex justify-center items-center w-full h-full text-center text-gray-500">
            Belum ada lowongan beasiswa yang tersedia.
        </p>
    @else
        <ul class="w-full flex flex-col gap-4 mt-4">
            @foreach ($daftarLowonganBeasiswa as $lowonganBeasiswa)
                <li>
                    <a href="{{ route('beasiswa.detail', $lowonganBeasiswa['slug']) }}" class="w-full p-4 bg-white rounded-xl border border-[#E2E2E2] flex flex-row items-center gap-5">
                        <div class="w-20 h-20 overflow-hidden flex items-center justify-center">
                            <img class="max-w-full max-h-full object-contain" src="{{ $lowonganBeasiswa['organizer_icon'] }}" />
                        </div>
                        <div class="flex flex-col items-start rounded gap-1">
                            <div class="w-full text-xl font-bold">{{ $lowonganBeasiswa['title'] }}</div>
                            <div class="w-full text-base font-medium">{{ $lowonganBeasiswa['organizer'] }}</div>
                            <div class="w-full text-[#777] text-xs font-normal">{{ $lowonganBeasiswa['createdAt'] }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="w-full flex items-center justify-center gap-2 mt-6 select-none">
            @if ($currentPage > 1)
                <a href="?page={{ $currentPage - 1 }}&search={{ $search }}"
                    class="w-8 h-8 bg-white border rounded-xl shadow-sm hover:bg-blue-50 transition text-gray-600 flex justify-center items-center">
                    <
                </a>
            @endif

            @for ($i = 1; $i <= $totalPages; $i++)
                <a href="?page={{ $i }}&search={{ $search }}"
                    class="w-8 h-8 flex items-center justify-center rounded-xl
                            {{ $i == $currentPage 
                                ? 'bg-blue-600 text-white shadow-md scale-[1.05]'
                                : 'bg-white text-gray-600 border hover:bg-blue-50' }}
                            transition">
                    {{ $i }}
                </a>
            @endfor

            @if ($currentPage < $totalPages)
                <a href="?page={{ $currentPage + 1 }}&search={{ $search }}"
                    class="w-8 h-8 bg-white border rounded-xl shadow-sm hover:bg-blue-50 transition text-gray-600 flex justify-center items-center">
                    >
                </a>
            @endif
        </div>
    @endif
@endsection