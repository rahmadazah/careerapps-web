@extends('layouts.app')

@section('title', 'MK-Relevan')

@section('content')
    <div class="w-full flex flex-col items-start gap-2">
        <div class="w-full text-black text-4xl font-bold leading-tight">{{ $detail['nama'] }}</div>
        <div class="w-full rounded-lg flex flex-col items-start gap-2">
            <div class="text-[#084169] text-2xl font-bold">Nilai = {{ $detail['grade'] }}</div>
            <div class="px-3 py-1 bg-[#C2F1D6] rounded-full flex items-center">
                <div class="text-[#27AE60] text-xs font-semibold leading-tight">Sangat Baik</div>
            </div>
        </div>
    </div>

    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Nilai diambil dari Kartu Hasil Studi.</span></div>
    </div>

    <div class="w-full flex flex-col items-start gap-4">
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">
            <div class="text-[#073B60] text-base font-bold leading-snug">Deskripsi Mata Kuliah</div>
            <div class="text-[#073B60] text-base font-normal leading-snug">
                {{ $detail['deskripsi'] ?? '-' }}
            </div>
        </div>

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
                <div class="text-[#073B60] text-base font-normal leading-snug">Tidak ada data CPMK.</div>
            @endif
        </div>

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
                <div class="text-[#073B60] text-base font-normal leading-snug">Tidak ada data Sub-CPMK.</div>
            @endif
        </div>
    </div>
@endsection
