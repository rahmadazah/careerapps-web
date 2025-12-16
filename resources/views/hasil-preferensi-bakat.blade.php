@extends('layouts.app')

@section('title', 'Preferensi Bakat')

@section('content')
    <div class="w-full flex flex-col items-start gap-2">
        <div class="w-full text-black text-4xl font-bold leading-tight">Preferensi Bakat</div>
    </div>
    <div class="w-full flex flex-col items-center">
        <img class="w-1/2" src="{{ asset('images/grafik-bakat.png') }}" alt="Preferensi Bakat">
    </div>
    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Semakin rendah nilai, semakin sesuai dengan preferensi bakatmu.</span></div>
    </div>
    <div class="w-full flex flex-col items-start gap-4">
        {{-- ini belum semua yak --}}
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-start flex-col gap-1">
            <div class="text-[#073B60] text-2xl font-bold leading-tight">Kinestetik</div>
            <div class="text-[#073B60] text-sm font-medium leading-snug">Skor = 3</div>
            <div class="text-[#073B60] text-base font-normal leading-snug">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
        </div>
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-start flex-col gap-1">
            <div class="text-[#073B60] text-2xl font-bold leading-tight">Interpersonal</div>
            <div class="text-[#073B60] text-sm font-medium leading-snug">Skor = 7</div>
            <div class="text-[#073B60] text-base font-normal leading-snug">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
        </div>
    </div>
@endsection