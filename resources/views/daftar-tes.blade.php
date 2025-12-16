@extends('layouts.app')

@section('title', 'Tes')

@section('content')
    <div class="w-full flex flex-col gap-4">
        @if (empty($kumpulanTes))
            <p class="text-center text-gray-500">Belum ada tes yang tersedia.</p>
        @else
            <ul class="w-full flex flex-col gap-4">
                @foreach ($kumpulanTes as $tes)
                    <li>
                        <div class="w-full p-4 bg-white rounded-xl border border-[#E2E2E2] flex flex-col items-end gap-3">
                            <div class="w-full flex flex-col gap-3 items-start">
                                <div class="flex flex-row gap-2 items-center mb-4">
                                    @if ($tes['slug'] === 'tes-mbti')
                                        <img class="w-9 h-9" src="{{ asset('icons/mbti.png') }}" alt="mbti"/>
                                    @elseif ($tes['slug'] === 'tes-preferensi-bakat')
                                        <img class="w-9 h-9" src="{{ asset('icons/bakat.png') }}" alt="bakat"/>
                                    @elseif ($tes['slug'] === 'tes-tipe-pekerjaan')
                                        <img class="w-9 h-9" src="{{ asset('icons/kerja.png') }}" alt="kerja"/>
                                    @endif
                                    <div class="text-black text-4xl font-bold leading-tight">
                                        {{ $tes['title'] }}
                                    </div>
                                </div>
                                <p class="text-[#073B60] text-base font-normal leading-6 max-w-full">{{ $tes['description'] }}</p>
                            </div>
                            <a href="{{ route('tes.detail', Str::slug($tes['title'])) }}" class="bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]">
                                Lihat Detail
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection