@extends('layouts.app')

@section('title', 'Nama Kegiatan Pengembangan')

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
            <div class="w-full text-black text-4xl font-bold leading-tight">{{ $kegiatan['title'] }}</div>
            <div class="w-full text-[#073B60] text-xl font-medium leading-tight">{{ $kegiatan['organizer'] }}</div>
        </div>

        <div class="w-1/4 rounded-xl border border-[#E2E2E2] overflow-hidden flex flex-col items-start p-2">
            <div class="overflow-hidden flex items-center gap-1">
                <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.00036 1.33334C3.16244 1.33334 1.66703 2.82876 1.66703 4.66459C1.65494 7.35001 4.87369 9.57668 5.00036 9.66668C5.00036 9.66668 8.34578 7.35001 8.33369 4.66668C8.33369 2.82876 6.83828 1.33334 5.00036 1.33334ZM5.00036 6.33334C4.07953 6.33334 3.33369 5.58751 3.33369 4.66668C3.33369 3.74584 4.07953 3.00001 5.00036 3.00001C5.92119 3.00001 6.66703 3.74584 6.66703 4.66668C6.66703 5.58751 5.92119 6.33334 5.00036 6.33334Z" fill="#073B60"/>
                </svg>
                <div class="text-[#073B60] text-base font-normal">{{ $kegiatan['location'] }}</div>
            </div>
            <div class="overflow-hidden flex items-center gap-1">
                <svg width="9" height="11" viewBox="0 0 9 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.89063 6.125H2.10938C1.98047 6.125 1.875 6.01953 1.875 5.89062V5.10938C1.875 4.98047 1.98047 4.875 2.10938 4.875H2.89063C3.01953 4.875 3.125 4.98047 3.125 5.10938V5.89062C3.125 6.01953 3.01953 6.125 2.89063 6.125ZM5 5.89062V5.10938C5 4.98047 4.89453 4.875 4.76563 4.875H3.98438C3.85547 4.875 3.75 4.98047 3.75 5.10938V5.89062C3.75 6.01953 3.85547 6.125 3.98438 6.125H4.76563C4.89453 6.125 5 6.01953 5 5.89062ZM6.875 5.89062V5.10938C6.875 4.98047 6.76953 4.875 6.64063 4.875H5.85938C5.73047 4.875 5.625 4.98047 5.625 5.10938V5.89062C5.625 6.01953 5.73047 6.125 5.85938 6.125H6.64063C6.76953 6.125 6.875 6.01953 6.875 5.89062ZM5 7.76562V6.98438C5 6.85547 4.89453 6.75 4.76563 6.75H3.98438C3.85547 6.75 3.75 6.85547 3.75 6.98438V7.76562C3.75 7.89453 3.85547 8 3.98438 8H4.76563C4.89453 8 5 7.89453 5 7.76562ZM3.125 7.76562V6.98438C3.125 6.85547 3.01953 6.75 2.89063 6.75H2.10938C1.98047 6.75 1.875 6.85547 1.875 6.98438V7.76562C1.875 7.89453 1.98047 8 2.10938 8H2.89063C3.01953 8 3.125 7.89453 3.125 7.76562ZM6.875 7.76562V6.98438C6.875 6.85547 6.76953 6.75 6.64063 6.75H5.85938C5.73047 6.75 5.625 6.85547 5.625 6.98438V7.76562C5.625 7.89453 5.73047 8 5.85938 8H6.64063C6.76953 8 6.875 7.89453 6.875 7.76562ZM8.75 2.6875V9.5625C8.75 10.0801 8.33008 10.5 7.8125 10.5H0.9375C0.419922 10.5 0 10.0801 0 9.5625V2.6875C0 2.16992 0.419922 1.75 0.9375 1.75H1.875V0.734375C1.875 0.605469 1.98047 0.5 2.10938 0.5H2.89063C3.01953 0.5 3.125 0.605469 3.125 0.734375V1.75H5.625V0.734375C5.625 0.605469 5.73047 0.5 5.85938 0.5H6.64063C6.76953 0.5 6.875 0.605469 6.875 0.734375V1.75H7.8125C8.33008 1.75 8.75 2.16992 8.75 2.6875ZM7.8125 9.44531V3.625H0.9375V9.44531C0.9375 9.50977 0.990234 9.5625 1.05469 9.5625H7.69531C7.75977 9.5625 7.8125 9.50977 7.8125 9.44531Z" fill="#073B60"/>
                </svg> 
                <div class="text-[#073B60] text-base font-normal">{{ $kegiatan['date'] }}</div>
            </div>
        </div>

        <div class="w-full flex flex-col items-center">
            <img class="w-1/2" src="{{ $kegiatan['banner'] }}" alt="Lowongan Kerja">
        </div>

        <div class="w-full flex flex-col items-start gap-1 border border-gray-200 rounded-lg">
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Deskripsi</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{{ $kegiatan['about'] }}</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{{ $kegiatan['detail'] }}</div>
            </div>
        </div>

        <button class="w-full bg-[#1080CF] text-white text-base font-normal leading-snug rounded-lg flex flex-col items-center p-3 hover:bg-[#0d6faf]"
            @click="externalUrl = '{{ $kegiatan['registration'] }}'; showModal = true;">Daftar Sekarang
        </button>
    </div>
</div>
@endsection