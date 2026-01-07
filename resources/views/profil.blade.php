@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div x-data="{
    showModal: false,
    modalType: '',
    externalUrlPassword: 'https://bais.ub.ac.id/'
}" class="w-full">
    
    <div 
        x-show="showModal && modalType === 'password'"
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-2xl p-6 w-[90%] max-w-sm" @click.outside="showModal = false">

            <div class="text-center">
                <div class="text-3xl font-bold">Konfirmasi</div>
                <p class="text-gray-700 text-base mt-2 leading-relaxed">
                    Kamu akan diarahkan ke halaman eksternal.<br>
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
                    class="px-6 py-2 bg-[#1080CF] text-white rounded-xl font-semibold"
                    @click="$refs.passwordForm.submit()">
                    Lanjutkan
                </button>
            </div>

        </div>
    </div>

    <div 
        x-show="showModal && modalType === 'logout'"
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-2xl p-6 w-[90%] max-w-sm" @click.outside="showModal = false">

            <div class="text-center">
                <div class="text-3xl font-bold">Keluar?</div>
                <p class="text-gray-700 text-base mt-2 leading-relaxed">
                    Kamu yakin ingin keluar?
                </p>
            </div>

            <div class="flex justify-center gap-4 mt-6">
                <button 
                    @click="showModal = false"
                    class="px-6 py-2 border border-gray-400 rounded-xl font-semibold">
                    Batal
                </button>

                <button 
                    class="px-6 py-2 bg-[#F73939] text-white rounded-xl font-semibold"
                    @click="$refs.logoutForm.submit()">
                    Keluar
                </button>
            </div>

        </div>
    </div>

    <div class="w-full flex flex-row justify-between items-center gap-4">
        <div class="text-black text-4xl font-bold leading-tight">Profil</div>

        <button 
            class="px-4 py-2 bg-[#1080CF] text-white text-base font-normal rounded-lg hover:bg-blue-700 transition"
            @click="
                modalType = 'password';
                showModal = true;
            "
        >
            Ubah Kata Sandi
        </button>
    </div>

    <div class="flex justify-center items-center gap-5 mt-4">
        <div class="w-48 h-48 rounded-full flex justify-center items-center relative">
            <img class="w-full rounded-full object-cover" src="{{ $profile['fotoProfil'] }}" alt="Profil">
        </div>
    </div>

    <div class="w-full flex flex-col items-start gap-4 mt-4">
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200">
            <div class="text-[#073B60] font-bold">Nama</div>
            <div class="text-[#073B60]">{{ $profile['name'] }}</div>
        </div>

        <div class="w-full p-3 bg-white rounded-lg border border-gray-200">
            <div class="text-[#073B60] font-bold">NIM</div>
            <div class="text-[#073B60]">{{ $profile['nim'] }}</div>
        </div>

        <div class="w-full p-3 bg-white rounded-lg border border-gray-200">
            <div class="text-[#073B60] font-bold">Fakultas</div>
            <div class="text-[#073B60]">{{ $profile['fakultas'] }}</div>
        </div>

        <div class="w-full p-3 bg-white rounded-lg border border-gray-200">
            <div class="text-[#073B60] font-bold">Departemen</div>
            <div class="text-[#073B60]">{{ $profile['departemen'] }}</div>
        </div>

        <div class="w-full p-3 bg-white rounded-lg border border-gray-200">
            <div class="text-[#073B60] font-bold">Program Studi</div>
            <div class="text-[#073B60]">{{ $profile['programStudi'] }}</div>
        </div>

        <div class="w-full p-3 bg-white rounded-lg border border-gray-200">
            <div class="text-[#073B60] font-bold">Jenjang</div>
            <div class="text-[#073B60]">{{ $profile['jenjang'] }}</div>
        </div>
    </div>

    <div class="mt-6 w-full">
        <button 
            class="w-full bg-[#F73939] rounded-lg p-3 text-white text-base font-normal"
            @click="
                modalType = 'logout';
                showModal = true;
            "
        >
            Keluar
        </button>
    </div>
    
    <form method="POST" action="{{ route('ubah.katasandi') }}" x-ref="passwordForm" class="hidden">
        @csrf
    </form>

    <form method="POST" action="{{ route('keluar') }}" x-ref="logoutForm" class="hidden">
        @csrf
    </form>

</div>
@endsection
