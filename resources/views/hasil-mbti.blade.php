@extends('layouts.app')

@section('title', 'Hardskill')

@section('content')
    <div class="w-full flex flex-col items-start gap-2">
        <div class="w-full text-black text-4xl font-bold leading-tight">MBTI</div>
    </div>
    <div class="w-full flex flex-col items-center">
        <img class="w-1/2" src="{{ asset('images/grafik-mbti.png') }}" alt="MBTI">
    </div>
    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Semakin tinggi nilai, semakin sesuai dengan sesuai dengan tipe MBTI kamu.</span></div>
    </div>
    <div class="w-full flex flex-col items-start gap-4">
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-start flex-col gap-1">
            <div class="text-[#073B60] text-2xl font-bold leading-tight">ENFP</div>
            <div class="text-[#073B60] text-sm font-medium leading-snug">Extroverts, Intuitives, Feelers, Perceivers</div>
            <div class="text-[#073B60] text-base font-normal leading-snug">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
        </div>
        {{-- ini belum semua yak --}}
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-start flex-col gap-1">
            <div class="text-[#073B60] text-2xl font-bold leading-tight">Extroverts</div>
            <div class="text-[#073B60] text-sm font-medium leading-snug">Skor = 80%</div>
            <div class="text-[#073B60] text-base font-normal leading-snug">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
        </div>
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-start flex-col gap-1">
            <div class="text-[#073B60] text-2xl font-bold leading-tight">Intuitives</div>
            <div class="text-[#073B60] text-sm font-medium leading-snug">Skor = 78%</div>
            <div class="text-[#073B60] text-base font-normal leading-snug">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
        </div>
    </div>
@endsection