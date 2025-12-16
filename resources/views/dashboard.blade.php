@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full text-black text-4xl font-bold leading-tight">Performa Kamu</div>
    <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-3">
        <div class="grid grid-rows-3 gap-3">
            <div class="row-span-2 w-full p-3 rounded-lg border border-gray-200 flex flex-col gap-2 justify-center ">
                <div class="text-[#073B60] text-2xl font-medium leading-tight">Nilai Total</div>
                <div class="flex flex-col gap-3">
                    <div class="text-[#084169] text-4xl font-bold">92,5%</div>
                    <div class="w-fit px-3 py-1 bg-[#C2F1D6] rounded-full flex items-center">
                        <div class="text-[#27AE60] text-xs font-semibold leading-tight">Sangat Baik</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('dashboard.hardskill') }}" class="p-2 bg-white rounded-lg border border-gray-200 flex items-center">
                    <img class="w-10 h-10" src="{{ asset('icons/hardskill.png') }}" alt="Hard Skills"/>
                    <div class="px-2 flex flex-col">
                        <div class="text-[#073B60] text-base font-medium">Hard Skills</div>
                        <div class="text-[#073B60] text-3xl font-bold">95%</div>
                    </div>
                    <img class="w-10 h-10 ml-auto" src="{{ asset('icons/arrow.png') }}" alt=""/>
                </a>

                <a href="{{ route('dashboard.softskill') }}" class="p-2 bg-white rounded-lg border border-gray-200 flex items-center">
                    <img class="w-10 h-10" src="{{ asset('icons/softskill.png') }}" alt="Soft Skills"/>
                    <div class="px-2 flex flex-col">
                        <div class="text-[#073B60] text-base font-medium">Soft Skills</div>
                        <div class="text-[#073B60] text-3xl font-bold">90%</div>
                    </div>
                    <img class="w-10 h-10 ml-auto" src="{{ asset('icons/arrow.png') }}" alt=""/>
                </a>
            </div>
        </div>

        <div class="grid grid-rows-3 gap-3">
            <a href="{{ route('tes.detail-hasil', 'tes-mbti') }}" class="w-full p-2 bg-white rounded-lg border border-gray-200 flex items-center gap-3">
                <img class="w-10 h-10" src="{{ asset('icons/mbti.png') }}" alt="MBTI"/>
                <div class="flex-1 flex flex-col">
                    <div class="text-[#073B60] text-base font-medium">MBTI</div>
                    <div class="text-[#073B60] text-2xl font-bold">{{ $hasilTes['mbti'] ?? '-' }}</div>
                </div>
                <img class="w-10 h-10 ml-auto" src="{{ asset('icons/arrow.png') }}" alt=""/>
            </a>

            <a href="{{ route('tes.detail-hasil', 'tes-preferensi-bakat') }}" class="w-full p-2 bg-white rounded-lg border border-gray-200 flex items-center gap-3">
                <img class="w-10 h-10" src="{{ asset('icons/bakat.png') }}" alt="Preferensi Bakat"/>
                <div class="flex-1 flex flex-col">
                    <div class="text-[#073B60] text-base font-medium">Preferensi Bakat</div>
                    <div class="text-[#073B60] text-2xl font-bold">{{ $hasilTes['preferensiBakat'] ?? '-' }}</div>
                </div>
                <img class="w-10 h-10 ml-auto" src="{{ asset('icons/arrow.png') }}" alt=""/>
            </a>

            <a href="{{ route('tes.detail-hasil', 'tes-tipe-pekerjaan') }}" class="w-full p-2 bg-white rounded-lg border border-gray-200 flex items-center gap-3">
                <img class="w-10 h-10" src="{{ asset('icons/kerja.png') }}" alt="Tipe Pekerjaan"/>
                <div class="flex-1 flex flex-col">
                    <div class="text-[#073B60] text-base font-medium">Tipe Pekerjaan</div>
                    <div class="text-[#073B60] text-2xl font-bold">{{ $hasilTes['tipePekerjaan'] ?? '-' }}</div>
                </div>
                <img class="w-10 h-10 ml-auto" src="{{ asset('icons/arrow.png') }}" alt=""/>
            </a>
        </div>
    </div>

    <div class="w-full bg-[#1080CF] rounded-lg flex items-center p-2">
        <div class="flex flex-col items-start">
            <div class="text-white text-base font-normal leading-snug">Kamu cocok menjadi</div>
            <div class="text-white text-4xl font-bold leading-tight">{{ $rekomendasiKarier }}</div>
        </div>
    </div>
    <div class="w-full p-2 rounded-lg border border-gray-200 flex flex-col items-start gap-1">
        <div class="text-[#073B60] text-base font-bold leading-snug">Mengapa kamu cocok?</div>
        <div class="text-[#073B60] text-base font-normal leading-snug">
            Dari hasil tes yang telah dikerjakan, tipe pekerjaan yang paling dominan pada dirimu adalah <span class="font-bold">{{ $hasilTes['tipePekerjaan'] ?? '-' }}</span> dengan MBTI <span class="font-bold">{{ $hasilTes['mbti'] ?? '-' }}</span> dan memiliki preferensi bakat dominan <span class="font-bold">{{ $hasilTes['preferensiBakat'] ?? '-' }}</span>.
        </div>
    </div>
    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start p-2">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Hasil bisa saja kurang sesuai, pemetaan ini dihitung berdasarkan skor tes dan Capaian Pembelajaran Mata Kuliah yang sudah kamu ambil.</span></div>
    </div>
@endsection