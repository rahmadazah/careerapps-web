@extends('layouts.app')

@section('title', 'Nama Lowongan Magang')

@section('content')
<div x-data="{ showModal: false, externalUrl: '' }" class="w-full">
    <div 
        x-show="showModal"
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-2xl p-6 w-[90%] max-w-sm"
            @click.outside="showModal = false">
            
            <div class="text-center">
                <div class="text-3xl font-bold">URL Eksternal</div>
                <p class="text-gray-700 text-base mt-2 leading-relaxed">
                    Kamu akan diarahkan ke URL eksternal.<br>
                    Lanjutkan?
                </p>
            </div>

            <div class="flex justify-center gap-4 mt-6">
                <button 
                    @click="showModal = false"
                    class="px-6 py-2 border border-gray-400 rounded-xl font-semibold">
                    Batal
                </button>
                <button 
                    @click="window.location.href = externalUrl"
                    class="px-6 py-2 bg-[#1080CF] text-white rounded-xl font-semibold">
                    Lanjutkan
                </button>
            </div>

        </div>
    </div>
    <div class="flex flex-col gap-4">
        <div class="w-full flex flex-col items-start gap-2">
            <div class="w-full text-black text-4xl font-bold leading-tight">{{ $lowonganMagang['title'] }}</div>
            <div class="w-full text-[#073B60] text-xl font-medium leading-tight">{{ $lowonganMagang['company'] }}</div>
        </div>

        <div class="w-1/4 rounded-xl border border-[#E2E2E2] overflow-hidden flex flex-col items-start p-2">
            <div class="overflow-hidden flex items-center gap-1">
                <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.00036 1.33334C3.16244 1.33334 1.66703 2.82876 1.66703 4.66459C1.65494 7.35001 4.87369 9.57668 5.00036 9.66668C5.00036 9.66668 8.34578 7.35001 8.33369 4.66668C8.33369 2.82876 6.83828 1.33334 5.00036 1.33334ZM5.00036 6.33334C4.07953 6.33334 3.33369 5.58751 3.33369 4.66668C3.33369 3.74584 4.07953 3.00001 5.00036 3.00001C5.92119 3.00001 6.66703 3.74584 6.66703 4.66668C6.66703 5.58751 5.92119 6.33334 5.00036 6.33334Z" fill="#073B60"/>
                </svg>
                <div class="text-[#073B60] text-base font-normal">{{ $lowonganMagang['location'] }}</div>
            </div>
        </div>

        {{-- <div class="w-full bg-[#1080CF] rounded-lg flex flex-col items-start gap-3 p-3">
            <div class="text-white text-base font-normal leading-snug">Profilmu 85% cocok dengan posisi ini!</div>
        </div> --}}

        <div class="w-full flex flex-col items-center">
            <img class="w-1/2" src="{{ $lowonganMagang['banner'] }}" alt="Lowongan Kerja">
        </div>

        <div class="w-full flex flex-col items-start gap-1 border border-gray-200 rounded-lg">
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Deskripsi</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganMagang['descriptions'])) !!}</div>
            </div>
            <div class="w-full p-2 items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Tanggung Jawab</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganMagang['responsibilities'])) !!}</div>
            </div>
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Persyaratan</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganMagang['requirements'])) !!}</div>
            </div>
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Manfaat</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganMagang['benefits'])) !!}</div>
            </div>
        </div>

        <button class="w-full bg-[#1080CF] text-white text-base font-normal leading-snug rounded-lg flex flex-col items-center p-3 hover:bg-[#0d6faf]"
            @click="externalUrl = '{{ $lowonganMagang['registration'] }}'; showModal = true;">Daftar Sekarang
        </button>
    </div>
</div>
@endsection