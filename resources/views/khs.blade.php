@extends('layouts.app')

@section('title', 'KRS')

@section('content')
    <div class="text-black text-4xl font-bold leading-tight mb-4">Semester {{ $semester['semester'] }}</div>
    <div class="w-full flex flex-col gap-5 items-end">
        <div class="w-full flex flex-row gap-5 items-start">
            <div class="w-1/4 p-3 bg-white rounded-lg border border-gray-200 flex flex-col">
                <div class="text-[#073B60] text-base font-medium">IPS</div>
                <div class="text-[#073B60] text-2xl font-bold">{{ $semester['ips'] }}</div>
            </div>
            <div class="w-1/4 p-3 bg-white rounded-lg border border-gray-200 flex flex-col">
                <div class="text-[#073B60] text-base font-medium">IPK</div>
                <div class="text-[#073B60] text-2xl font-bold">{{ $semester['ipk'] }}</div>
            </div>
            <div class="w-1/4 p-3 bg-white rounded-lg border border-gray-200 flex flex-col">
                <div class="text-[#073B60] text-base font-medium">SKS Saat Ini</div>
                <div class="text-[#073B60] text-2xl font-bold">{{ $semester['sks'] }}</div>
            </div>
            <div class="w-1/4 p-3 bg-white rounded-lg border border-gray-200 flex flex-col">
                <div class="text-[#073B60] text-base font-medium">SKS Kumulatif</div>
                <div class="text-[#073B60] text-2xl font-bold">
                    {{ $semester['sks_kumulatif'] }}
                </div>
            </div>
        </div>
        <div class="w-full p-4 rounded-lg border border-[#E2E2E2] flex justify-between items-center">
            <div class="text-[#073B60] text-base font-medium">
                Rekomendasi SKS yang dapat diambil di semester berikutnya
            </div>
            <div class="text-[#073B60] text-2xl font-bold leading-[42px]">
                {{ $semester['rekomendasi_sks'] }}
            </div>
        </div>
    </div>
    <div class="w-full flex flex-col items-start gap-2">
        <div class="text-[#073B60] text-base font-bold leading-snug">Mata Kuliah yang Diambil</div>
        <div class="w-full flex flex-col items-start gap-4">
            @if (empty($kumpulanMK))
                <p class="text-center text-gray-500">Belum ada Mata Kuliah yang Diambil.</p>
            @else
                <ul class="w-full flex flex-col gap-4">
                    @foreach ($kumpulanMK as $MK)
                        <li>
                            <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-center flex-wrap gap-3">
                                <div class="flex-1 flex flex-col items-start gap-1">
                                    <div class="text-[#073B60] text-2xl font-bold leading-tight">{{ $MK['name'] }}</div>
                                    <div class="text-[#F79B39] text-sm font-medium leading-snug">{{ $MK['code'] }} | {{ $MK['course']['sks'] ?? '-' }} SKS</div>                    
                                </div>
                                <div class="text-[#073B60] text-4xl font-bold leading-tight">{{ $MK['grade'] }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection