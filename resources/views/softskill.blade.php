@extends('layouts.app')

@section('title', 'Softskill')

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
        <div class="w-full text-black text-4xl font-bold leading-tight">Softskill</div>
        <div class="w-full flex flex-col items-start gap-2">
            <div class="w-full rounded-lg flex flex-col items-start gap-2">
                <div class="text-[#084169] text-4xl font-bold">92,5%</div>
                <div class="px-3 py-1 bg-[#C2F1D6] rounded-full flex items-center">
                    <div class="text-[#27AE60] text-xs font-semibold leading-tight">Sangat Baik</div>
                </div>
            </div>
        </div>
        <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
            <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Nilai dihitung berdasarkan softskills yang kamu dapatkan dari kegiatan kemahasiswaan yang kamu ikuti.</span></div>
        </div>
        <div class="w-full flex flex-col items-start gap-2">
            <div class="text-[#073B60] text-base font-bold leading-snug">
                Softskills yang Sudah Dimiliki
            </div>

            <div class="w-full flex flex-col items-start gap-4">

                @if(empty($softskills))
                    <div class="w-full p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-[#073B60] text-sm font-medium leading-snug">
                            Belum ada softskill yang dimiliki.
                        </div>
                    </div>
                @else
                    @foreach($softskills as $skill => $sumber)
                        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">                
                            <div class="text-[#073B60] text-2xl font-bold leading-tight">
                                {{ ucwords($skill) }}
                            </div>

                            <div class="text-[#073B60] text-sm font-medium leading-snug">
                                Didapatkan dari pengalaman sebagai
                                @foreach($sumber as $index => $nama)
                                    <span class="font-bold">{{ $nama }}</span>@if(!$loop->last), @endif
                                @endforeach
                                .
                            </div>                    
                        </div>
                    @endforeach
                @endif

            </div>
        </div>

        <div class="w-full flex flex-col items-start gap-2">
            <div class="text-[#073B60] text-base font-bold leading-snug">Rekomendasi Organisasi</div>
            <div class="w-full p-4 bg-white rounded-xl border border-[#E2E2E2] flex flex-col items-end gap-3">
                <div class="w-full flex flex-col gap-3 items-start">
                    <div class="text-[#073B60] text-2xl font-bold leading-tight">{{ $randomOrganisasi['nama'] }}</div>
                    <div class="text-[#073B60] text-sm font-medium leading-snug">{{ $randomOrganisasi['deskripsi'] }}</div>
                </div>
                <button class="p-2 bg-[#1080CF] text-white text-xs font-bold rounded-full flex items-center hover:bg-[#0d6faf]"
                @click="externalUrl = '{{ $randomOrganisasi['url'] }}'; showModal = true;">
                    Informasi Selengkapnya
                    <span class="inline-flex">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.9999 3.3335C12.1767 3.3335 12.3463 3.40373 12.4713 3.52876C12.5963 3.65378 12.6665 3.82335 12.6665 4.00016V9.3335C12.6665 9.51031 12.5963 9.67988 12.4713 9.8049C12.3463 9.92992 12.1767 10.0002 11.9999 10.0002C11.8231 10.0002 11.6535 9.92992 11.5285 9.8049C11.4034 9.67988 11.3332 9.51031 11.3332 9.3335V5.6095L4.69988 12.2428C4.57414 12.3643 4.40574 12.4315 4.23094 12.4299C4.05614 12.4284 3.88894 12.3583 3.76533 12.2347C3.64172 12.1111 3.57161 11.9439 3.57009 11.7691C3.56857 11.5943 3.63577 11.4259 3.75721 11.3002L10.3905 4.66683H6.66654C6.48973 4.66683 6.32016 4.59659 6.19514 4.47157C6.07011 4.34654 5.99988 4.17697 5.99988 4.00016C5.99988 3.82335 6.07011 3.65378 6.19514 3.52876C6.32016 3.40373 6.48973 3.3335 6.66654 3.3335H11.9999Z" fill="white" fill-opacity="0.8"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
        <div class="w-full flex flex-col items-start gap-2">
            <div class="text-[#073B60] text-base font-bold leading-snug">Rekomendasi Kepanitiaan</div>
            <div class="w-full p-4 bg-white rounded-xl border border-[#E2E2E2] flex flex-col items-end gap-3">
                <div class="w-full flex flex-col gap-3 items-start">
                    <div class="text-[#073B60] text-2xl font-bold leading-tight">{{ $randomKepanitiaan['nama'] }}</div>
                    <div class="text-[#073B60] text-sm font-medium leading-snug">{{ $randomKepanitiaan['deskripsi'] }}</div>
                </div>
                <button class="p-2 bg-[#1080CF] text-white text-xs font-bold rounded-full flex items-center hover:bg-[#0d6faf]"
                @click="externalUrl = '{{ $randomKepanitiaan['url'] }}'; showModal = true;">
                    Informasi Selengkapnya
                    <span class="inline-flex">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.9999 3.3335C12.1767 3.3335 12.3463 3.40373 12.4713 3.52876C12.5963 3.65378 12.6665 3.82335 12.6665 4.00016V9.3335C12.6665 9.51031 12.5963 9.67988 12.4713 9.8049C12.3463 9.92992 12.1767 10.0002 11.9999 10.0002C11.8231 10.0002 11.6535 9.92992 11.5285 9.8049C11.4034 9.67988 11.3332 9.51031 11.3332 9.3335V5.6095L4.69988 12.2428C4.57414 12.3643 4.40574 12.4315 4.23094 12.4299C4.05614 12.4284 3.88894 12.3583 3.76533 12.2347C3.64172 12.1111 3.57161 11.9439 3.57009 11.7691C3.56857 11.5943 3.63577 11.4259 3.75721 11.3002L10.3905 4.66683H6.66654C6.48973 4.66683 6.32016 4.59659 6.19514 4.47157C6.07011 4.34654 5.99988 4.17697 5.99988 4.00016C5.99988 3.82335 6.07011 3.65378 6.19514 3.52876C6.32016 3.40373 6.48973 3.3335 6.66654 3.3335H11.9999Z" fill="white" fill-opacity="0.8"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
        <div class="w-full flex flex-col items-start gap-2">
            <div class="text-[#073B60] text-base font-bold leading-snug">Rekomendasi Lomba</div>
            <div class="w-full p-4 bg-white rounded-xl border border-[#E2E2E2] flex flex-col items-end gap-3">
                <div class="w-full flex flex-col gap-3 items-start">
                    <div class="text-[#073B60] text-2xl font-bold leading-tight">{{ $randomLomba['nama'] }}</div>
                    <div class="text-[#073B60] text-sm font-medium leading-snug">{{ $randomLomba['deskripsi'] }}</div>
                </div>
                <button class="p-2 bg-[#1080CF] text-white text-xs font-bold rounded-full flex items-center hover:bg-[#0d6faf]"
                @click="externalUrl = '{{ $randomLomba['url'] }}'; showModal = true;">
                    Informasi Selengkapnya
                    <span class="inline-flex">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.9999 3.3335C12.1767 3.3335 12.3463 3.40373 12.4713 3.52876C12.5963 3.65378 12.6665 3.82335 12.6665 4.00016V9.3335C12.6665 9.51031 12.5963 9.67988 12.4713 9.8049C12.3463 9.92992 12.1767 10.0002 11.9999 10.0002C11.8231 10.0002 11.6535 9.92992 11.5285 9.8049C11.4034 9.67988 11.3332 9.51031 11.3332 9.3335V5.6095L4.69988 12.2428C4.57414 12.3643 4.40574 12.4315 4.23094 12.4299C4.05614 12.4284 3.88894 12.3583 3.76533 12.2347C3.64172 12.1111 3.57161 11.9439 3.57009 11.7691C3.56857 11.5943 3.63577 11.4259 3.75721 11.3002L10.3905 4.66683H6.66654C6.48973 4.66683 6.32016 4.59659 6.19514 4.47157C6.07011 4.34654 5.99988 4.17697 5.99988 4.00016C5.99988 3.82335 6.07011 3.65378 6.19514 3.52876C6.32016 3.40373 6.48973 3.3335 6.66654 3.3335H11.9999Z" fill="white" fill-opacity="0.8"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div> 
    </div>
</div>   
@endsection