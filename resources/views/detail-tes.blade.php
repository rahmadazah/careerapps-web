@extends('layouts.app')

@section('title', $detailTes['title'])

@section('content')
    <div class="text-4xl font-bold text-black">{{ $detailTes['title'] }}</div>
    <div class="w-full p-3 bg-white rounded-xl border border-[#E2E2E2]">
        <p class="text-[#073B60] text-base">{{ $detailTes['description'] }}</p>
    </div>
    <div class="text-sm font-semibold text-[#073B60]">Hasil Tes</div>
    <div class="w-full p-3 bg-white rounded-xl border border-[#E2E2E2]">
        @if(!$hasilAkhir)
            <p class="text-[#073B60]">Kamu belum pernah mengerjakan tes ini.</p>
        @else
            @if($slug === 'tes-mbti')
                <div class="gap-2">
                    <p class="text-2xl font-bold text-[#073B60]">{{ $hasilAkhir }}</p>
                    <p class="text-[#F79B39]">{{ implode(', ', $mbtiMapping) }}</p>
                </div>
            @endif
            @if($slug === 'tes-preferensi-bakat')
                <div class="gap-2">
                    <p class="text-2xl font-bold text-[#073B60]">{{ $hasilAkhir }}</p>
                    <p class="text-[#F79B39]">Skor : {{ $skor }}</p>
                </div>
            @endif
            @if($slug === 'tes-tipe-pekerjaan')
                <div class="gap-2">
                    <p class="text-2xl font-bold text-[#073B60]">{{ $hasilAkhir }}</p>
                    <p class="text-[#F79B39]">Skor : {{ $skor }}</p>
                </div>
            @endif
            <p class="text-[#073B60] mt-2">{{ $penjelasan }}</p>
            <div class="w-full flex justify-end mt-2">
                <a href="{{ route('tes.detail-hasil', $slug) }}" class="w-fit bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]">
                    Lihat Detail
                </a>
            </div>
        @endif
    </div>
    @if(!$hasilAkhir)
        <a href="{{ route('tes.persetujuan', $slug) }}"
            class="w-full bg-[#1080CF] hover:bg-[#0c6bb0] transition text-white text-base font-semibold text-center py-3 rounded-lg">
            Ambil Tes
        </a>
    @else
        <a href="{{ route('tes.persetujuan', $slug) }}"
            class="w-full bg-[#1080CF] hover:bg-[#0c6bb0] transition text-white text-base font-semibold text-center py-3 rounded-lg">
            Ambil Ulang Tes
        </a>
    @endif
@endsection
