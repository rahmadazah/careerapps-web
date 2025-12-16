@extends('layouts.app')

@section('title', 'Persetujuan Pengguna')

@section('content')
    <div class="w-full flex flex-col items-start gap-2">
        <div class="w-full text-black text-4xl font-bold leading-tight">Persetujuan Pengguna</div>
    </div>
    <div class="w-full flex flex-col items-start gap-4">
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-start flex-col gap-1">
            <div class="text-[#073B60] text-base font-normal leading-relaxed whitespace-pre-line">{{ $persetujuanPengguna['detail'] }}</div>
        </div>
        <div class="w-full p-3 bg-white rounded-lg border border-gray-200 flex items-start flex-col gap-1">
            <label class="flex items-start gap-2">
                <input type="checkbox" id="setujuCheckbox" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="text-[#073B60] text-base font-normal leading-snug">Saya menyetujui syarat & ketentuan yang berlaku</span>
        </label>
        </div>
    </div>

    <form method="POST" action="{{ route('tes.mulai', ['slug' => Str::slug($tes['title'])]) }}" class="w-full flex flex-col gap-4">
        @csrf
        <button class="w-full bg-[#1080CF] rounded-lg flex flex-col items-center gap-3 p-3 text-white text-base font-normal leading-snug">
            Mulai Tes
        </button>    
    </form>

    <script>
        const checkbox = document.getElementById('setujuCheckbox');
        const button = document.getElementById('mulaiTesButton');

        checkbox.addEventListener('change', function () {
            if (this.checked) {
                button.classList.remove('pointer-events-none', 'opacity-50');
            } else {
                button.classList.add('pointer-events-none', 'opacity-50');
            }
        });
    </script>

@endsection