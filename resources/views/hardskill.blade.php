@extends('layouts.app')

@section('title', 'Hardskill')

@section('content')
    <div class="w-full flex flex-col items-start gap-2">
        <div class="w-full text-black text-4xl font-bold leading-tight">Hardskill</div>
        <div class="w-full rounded-lg flex flex-col items-start gap-2">
            <div class="text-[#084169] text-4xl font-bold">92,5%</div>
            <div class="px-3 py-1 bg-[#C2F1D6] rounded-full flex items-center">
                <div class="text-[#27AE60] text-xs font-semibold leading-tight">Sangat Baik</div>
            </div>
        </div>
    </div>
    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Nilai dihitung berdasarkan hardskill yang kamu dapatkan dari Capaian Pembelajaran Mata Kuliah yang sudah kamu ambil dan relevan dengan hasil pemetaan karier kamu.</span></div>
    </div>
    <div class="w-full flex flex-col items-start gap-2">
        <div class="text-[#073B60] text-base font-bold leading-snug">Mata Kuliah Relevan</div>
        <div class="w-full flex flex-col items-start gap-4">
            @forelse ($mkRelevan as $mk)
                <a href="{{ route('dashboard.relevan', ['slug' => $mk['slug']]) }}" class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-center flex-wrap gap-3">
                    <div class="flex-1 flex flex-col items-start gap-1">
                        <div class="text-[#073B60] text-2xl font-bold leading-tight">{{ $mk['nama'] }}</div>
                        <div class="text-[#F79B39] text-sm font-medium leading-snug">Nilai = {{ strtoupper($mk['nilai']) }}</div>                    
                    </div>
                    <img class="w-10 h-12" src="{{ asset('icons/arrow.png') }}" alt=""/>
                </a>
            @empty
                <p class="text-[#073B60] text-base font-medium">Belum ada mata kuliah yang diambil.</p>
            @endforelse
        </div>
    </div>

    <div class="w-full flex flex-col items-start gap-2">
        <div class="text-[#073B60] text-base font-bold leading-snug">Mata Kuliah Rekomendasi</div>
        <div class="w-full flex flex-col items-start gap-4">
            @forelse ($mkRekomendasi as $mk)
                <a href="{{ route('dashboard.rekomendasi', ['slug' => $mk['slug']]) }}" class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-center flex-wrap gap-3">
                    <div class="flex-1 flex flex-col items-start gap-1">
                        <div class="text-[#073B60] text-2xl font-bold leading-tight">{{ $mk['nama'] }}</div>
                        <div class="text-[#F79B39] text-sm font-medium leading-snug">{{ $mk['kode'] }} | {{ $mk['sks'] }} SKS</div>                    
                    </div>
                    <img class="w-10 h-12" src="{{ asset('icons/arrow.png') }}" alt=""/>
                </a>
            @empty
                <p class="text-[#073B60] text-base font-medium">Tidak ada rekomendasi mata kuliah.</p>
            @endforelse
        </div>
    </div>
@endsection