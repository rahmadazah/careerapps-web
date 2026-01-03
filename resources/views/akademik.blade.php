@extends('layouts.app')

@section('title', 'Informasi Akademik')

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

    <div class="w-full p-2">
        <div class="flex flex-row gap-2 items-center mb-4">
            <img class="w-9 h-9" src="{{ asset('icons/ip.png') }}" alt="IP"/>
            <div class="text-black text-4xl font-bold leading-tight">
                Riwayat Indeks Prestasi
            </div>
        </div>

        @if ($kumpulanSemester->isEmpty())
            <p class="text-center text-gray-500">Belum ada riwayat indeks prestasi tersedia.</p>
        @else
            <div class="flex flex-col gap-2">
                @foreach ($kumpulanSemester as $semester)
                    <div x-data="{ open: false }" 
                        class="p-4 bg-white rounded-lg border border-[#E2E2E2]">

                        <div class="flex justify-between cursor-pointer" @click="open = !open">
                            <div class="text-[#073B60] text-xl font-bold">Semester {{ $semester['semester'] }}</div>
                            <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div x-show="open" x-collapse class="mt-3 flex flex-col gap-2">
                            <div class="flex flex-row gap-2">
                                <div class="w-1/4 p-3 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">IPS</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $semester['ips'] }}</div>
                                </div>
                                <div class="w-1/4 p-3 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">IPK</div>
                                    <div class="text-[#073B60] text-2xl font-bold">{{ $semester['ipk'] }}</div>
                                </div>
                                <div class="w-1/4 p-3 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">SKS Saat Ini</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $semester['sks'] }}</div>
                                </div>
                                <div class="w-1/4 p-3 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">SKS Kumulatif</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $semester['sks_kumulatif'] }}</div>
                                </div>
                            </div>

                            <div class="p-4 border rounded-lg flex justify-between">
                                <div class="text-[#073B60] text-base">
                                    Rekomendasi Jumlah SKS semester berikutnya
                                </div>
                                <div class="text-[#073B60] text-xl font-bold">
                                    {{ $semester['rekomendasi_sks'] }}
                                </div>
                            </div>

                            <div class="w-full flex justify-end p-2">
                                <a href="{{ route('akademik.khs', $semester['semester']) }}" class="bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="w-full p-2">
        <div class="flex justify-between items-center mb-4">
            <div class="flex flex-row gap-2 items-center">
                <img class="w-9 h-9" src="{{ asset('icons/pkl.png') }}" alt="PKL"/>
                <div class="text-black text-4xl font-bold leading-tight">
                    Riwayat Praktik Kerja Lapangan
                </div>
            </div>
            <button 
                class="bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]"
                @click="externalUrl = 'https://siam.ub.ac.id/kemahasiswaan/mbkm'; showModal = true;">
                + Tambah Data
            </button>
        </div>

        @if ($kumpulanPKL->isEmpty())
            <p class="text-center text-gray-500">Belum ada riwayat Praktik Kerja Lapangan.</p>
        @else
            <ul class="flex flex-col gap-2">
                @foreach ($kumpulanPKL as $PKL)
                    <li>
                        <div x-data="{ open: false }" class="p-4 bg-white border rounded-lg">
                            <div class="flex justify-between cursor-pointer" @click="open = !open">
                                <div class="text-[#073B60] text-xl font-bold">{{ $PKL['organizer'] }}</div>
                                <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <div x-show="open" x-collapse class="mt-3 flex flex-col gap-2">
                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">Deskripsi</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $PKL['description'] }}</div>
                                </div>

                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">Waktu Kegiatan</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $PKL['dateStart'] }} - {{ $PKL['dateEnd'] }}</div>
                                </div>

                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">Status</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $PKL['status'] }}</div>
                                </div>
                            </div>

                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="w-full p-2">
        <div class="flex justify-between items-center mb-4">
            <div class="flex flex-row gap-2 items-center">
                <img class="w-9 h-9" src="{{ asset('icons/kkn.png') }}" alt="KKN"/>
                <div class="text-black text-4xl font-bold leading-tight">
                    Riwayat Kuliah Kerja Nyata
                </div>
            </div>
            <button 
                class="bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]"
                @click="externalUrl = 'https://siam.ub.ac.id/kemahasiswaan/kkn/pendaftaran'; showModal = true;">
                + Tambah Data
            </button>
        </div>

        @if ($kumpulanKKN->isEmpty())
            <p class="text-center text-gray-500">Belum ada riwayat Kuliah Kerja Nyata.</p>
        @else
            <ul class="flex flex-col gap-2">
                @foreach ($kumpulanKKN as $KKN)
                    <li>
                        <div x-data="{ open: false }" class="p-4 bg-white border rounded-lg">
                            <div class="flex justify-between cursor-pointer" @click="open = !open">
                                <div class="text-[#073B60] text-xl font-bold">{{ $KKN['description'] }}</div>
                                <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <div x-show="open" x-collapse class="mt-3 flex flex-col gap-2">
                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">Lokasi</div>
                                    <div class="text-[#073B60] text-xl font-bold">
                                        {{ $KKN['village'] }}, {{ $KKN['subdistrict'] }}, {{ $KKN['district'] }}, {{ $KKN['regency'] }}
                                    </div>
                                </div>

                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">Dosen Pembimbing Lapangan</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $KKN['dpl'] }}</div>
                                </div>

                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">Waktu Kegiatan</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $KKN['startDate'] }} - {{ $KKN['endDate'] }}</div>
                                </div>

                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[#073B60]">Status</div>
                                    <div class="text-[#073B60] text-xl font-bold">{{ $KKN['status'] }}</div>
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
