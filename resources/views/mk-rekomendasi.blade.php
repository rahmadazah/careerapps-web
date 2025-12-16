@extends('layouts.app')

@section('title', 'MK Rekomendasi')

@section('content')
<div class="w-full flex flex-col items-start gap-2">
    <div class="w-full text-black text-4xl font-bold leading-tight">
        {{ $detail['nama'] }}
    </div>
    <div class="text-[#F79B39] text-base font-bold leading-snug">
        {{ $detail['kode'] }} | {{ $detail['sks'] }} SKS
    </div>        
</div>

<div class="w-full flex flex-col items-start gap-4">
    {{-- Deskripsi MK --}}
    <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">
        <div class="text-[#073B60] text-base font-bold leading-snug">Deskripsi Mata Kuliah</div>
        <div class="text-[#073B60] text-base font-normal leading-snug">
            {{ $detail['deskripsi'] ?? '-' }}
        </div>
    </div>

    {{-- CPMK --}}
    <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex flex-col gap-2">
        <div class="text-[#073B60] text-base font-bold leading-snug">
            Capaian Pembelajaran Mata Kuliah
        </div>
        @if(!empty($detail['cpmk']))
            <ul class="list-disc list-inside text-[#073B60] text-base font-normal leading-snug">
                @foreach($detail['cpmk'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <div class="text-gray-500 italic">Tidak ada data CPMK.</div>
        @endif
    </div>

    {{-- Sub CPMK --}}
    <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex flex-col gap-2">
        <div class="text-[#073B60] text-base font-bold leading-snug">
            Sub Capaian Pembelajaran Mata Kuliah
        </div>
        @if(!empty($detail['subcpmk']))
            <ul class="list-disc list-inside text-[#073B60] text-base font-normal leading-snug">
                @foreach($detail['subcpmk'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <div class="text-gray-500 italic">Tidak ada data Sub-CPMK.</div>
        @endif
    </div>

    {{-- Prasyarat --}}
    <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">
        <div class="text-[#073B60] text-base font-bold leading-snug">Mata Kuliah Prasyarat</div>
        <div class="text-[#073B60] text-base font-normal leading-snug">
            {{ $detail['prasyarat'] ?? '-' }}
        </div>
    </div>
</div>
@endsection
