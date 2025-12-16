@extends('layouts.app')

@section('title', 'Informasi Kemahasiswaan')

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
                    class="px-6 py-2 border border-gray-400 rounded-xl font-semibold"
                >
                    Batal
                </button>

                <button 
                    @click="window.location.href = externalUrl"
                    class="px-6 py-2 bg-[#1080CF] text-white rounded-xl font-semibold"
                >
                    Lanjutkan
                </button>
            </div>

        </div>
    </div>

    <div class="w-full p-2">
        <div class="flex justify-between items-center w-full mb-4">
            <div class="flex flex-row gap-2 items-center">
                <img class="w-9 h-9" src="{{ asset('icons/organisasi.png') }}" alt="IP"/>
                <div class="text-black text-4xl font-bold leading-tight">
                    Riwayat Organisasi
                </div>
            </div>
            <button 
                class="bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]"
                @click="
                    externalUrl = 'https://siam.ub.ac.id/kemahasiswaan/aktivitas';
                    showModal = true;
                "
            >
                + Tambah Data
            </button>
        </div>

        @if (empty($daftarOrganisasi))
            <p class="text-center text-gray-500">Belum ada riwayat organisasi yang tersedia.</p>
        @else
            <ul class="flex flex-col gap-2">
                @foreach ($daftarOrganisasi as $organisasi)
                <li>
                    <div x-data="{ open: false }" class="p-4 bg-white rounded-lg border border-[#E2E2E2]">
                        <div class="flex justify-between cursor-pointer" @click="open = !open">
                            <div class="text-[#073B60] text-xl font-bold">{{ $organisasi['title'] }}</div>
                            <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div x-show="open" x-collapse class="mt-3 flex flex-col gap-2">
                            <div class="p-2 bg-white rounded-lg border">
                                <div class="text-[#073B60] text-base">Jabatan</div>
                                <div class="text-[#073B60] text-xl font-bold">{{ $organisasi['position'] }}</div>
                            </div>
                            <div class="p-2 bg-white rounded-lg border">
                                <div class="text-[#073B60] text-base">Periode</div>
                                <div class="text-[#073B60] text-xl font-bold">{{ $organisasi['dateStart'] }} - {{ $organisasi['dateEnd'] }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="w-full p-2">
        <div class="flex flex-row gap-2 items-center mb-4">
            <img class="w-9 h-9" src="{{ asset('icons/kepanitiaan.png') }}" alt="IP"/>
            <div class="text-black text-4xl font-bold leading-tight">
                Riwayat Kepanitiaan
            </div>
        </div>

        @if (empty($daftarKepanitiaan))
            <p class="text-center text-gray-500">Belum ada riwayat kepanitiaan yang tersedia.</p>
        @else
            <ul class="flex flex-col gap-2">
                @foreach ($daftarKepanitiaan as $kepanitiaan)
                <li>
                    <div x-data="{ open: false }" class="p-4 bg-white rounded-lg border border-[#E2E2E2]">
                        <div class="flex justify-between cursor-pointer" @click="open = !open">
                            <div class="text-[#073B60] text-xl font-bold">{{ $kepanitiaan['name'] }}</div>
                            <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div x-show="open" x-collapse class="mt-3 flex flex-col gap-2">
                            <div class="p-2 bg-white rounded-lg border">
                                <div class="text-[#073B60] text-base">Jabatan</div>
                                <div class="text-[#073B60] text-xl font-bold">{{ $kepanitiaan['position'] }}</div>
                            </div>
                            <div class="p-2 bg-white rounded-lg border">
                                <div class="text-[#073B60] text-base">Periode</div>
                                <div class="text-[#073B60] text-xl font-bold">{{ $kepanitiaan['startDate'] }} - {{ $kepanitiaan['endDate'] }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="w-full p-2">
        <div class="flex justify-between items-center w-full mb-4">
            <div class="flex flex-row gap-2 items-center">
                <img class="w-9 h-9" src="{{ asset('icons/prestasi.png') }}" alt="IP"/>
                <div class="text-black text-4xl font-bold leading-tight">
                    Riwayat Prestasi
                </div>
            </div>
            <button 
                class="bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]"
                @click="
                    externalUrl = 'https://siam.ub.ac.id/kemahasiswaan/prestasi';
                    showModal = true;
                "
            >
                + Tambah Data
            </button>
        </div>

        @if (empty($daftarPencapaian))
            <p class="text-center text-gray-500">Belum ada riwayat prestasi yang tersedia.</p>
        @else
            <ul class="flex flex-col gap-2">
                @foreach ($daftarPencapaian as $pencapaian)
                <li>
                    <div x-data="{ open: false }" class="p-4 bg-white rounded-lg border border-[#E2E2E2]">
                        <div class="flex justify-between cursor-pointer" @click="open = !open">
                            <div class="text-[#073B60] text-xl font-bold">{{ $pencapaian['name'] }}</div>
                            <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div x-show="open" x-collapse class="mt-3 flex flex-col gap-2">
                            <div class="p-2 bg-white rounded-lg border">
                                <div class="text-[#073B60] text-base">Capaian</div>
                                <div class="text-[#073B60] text-xl font-bold">{{ $pencapaian['accomplishments'] }}</div>
                            </div>
                            <div class="p-2 bg-white rounded-lg border">
                                <div class="text-[#073B60] text-base">Jenis</div>
                                <div class="text-[#073B60] text-xl font-bold">{{ $pencapaian['participation_type'] }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>

@endsection
