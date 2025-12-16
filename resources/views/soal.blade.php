@extends('layouts.app')

@section('title', 'Soal Tes')

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    <div class="w-full lg:w-1/4 bg-white rounded-2xl p-6 shadow-md flex flex-col items-center gap-4">
        <div id="timer" class="bg-[#FF9300] text-white text-lg font-bold px-6 py-2 rounded-xl text-center w-full">
            30:00
        </div>
        <div class="flex flex-wrap justify-center gap-2 overflow-y-auto max-h-[300px]">
            @foreach ($pertanyaanList as $index => $p)
                <a href="{{ route('tes.soal', ['slug' => $slug, 'nomor' => $index + 1]) }}"
                class="w-10 h-10 flex items-center justify-center rounded-xl font-bold
                        {{ $nomor == $index + 1 
                            ? 'bg-[#1080CF] text-white' 
                            : (session()->has('jawaban.' . ($index + 1)) 
                                ? 'bg-blue-100 text-[#1080CF]' 
                                : 'border border-[#1080CF] text-[#1080CF]') }}">
                    {{ $index + 1 }}
                </a>
            @endforeach
        </div>

        {{-- ====== TOMBOL SELESAI (MODAL) ====== --}}
        <form action="{{ route('tes.selesaikan', ['slug' => $slug]) }}" method="POST" class="w-full mt-4">
            @csrf
            <button type="button" id="btnConfirmFinish"
                class="bg-[#1080CF] text-white font-bold px-6 py-2 rounded-xl hover:bg-[#0b6cb2] transition w-full">
                Selesai
            </button>
        </form>
        {{-- ===================================== --}}

    </div>

    <div class="flex-1 bg-white rounded-2xl p-6 shadow-md flex flex-col justify-between">
        <div>
            <h2 class="text-[#073B60] font-semibold mb-4 text-lg">Soal {{ $nomor }}</h2>
            <p class="text-[#073B60] mb-6 leading-relaxed">
                {{ $pertanyaan['questionText'] }}
            </p>

            <form action="{{ route('tes.simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="nomor" value="{{ $nomor }}">
                
                @foreach ($pertanyaan['Choices'] as $choice)
                    @php
                        $huruf = $choice['huruf'] ?? '';
                        $text = $choice['text'] ?? '';
                    @endphp

                    <label class="flex items-center gap-2 mb-3 cursor-pointer">
                        <input 
                            type="{{ $pertanyaan['questionType'] === 'CHECKBOX' ? 'checkbox' : 'radio' }}"
                            name="{{ $pertanyaan['questionType'] === 'CHECKBOX' ? 'jawaban[]' : 'jawaban' }}"
                            value="{{ $huruf }}"
                            class="accent-[#073B60]"
                            {{ in_array($huruf, (array) session('jawaban.' . $nomor, [])) ? 'checked' : '' }}
                            {{ $pertanyaan['questionType'] === 'RADIO' ? 'required' : '' }}>
                        <span class="text-[#073B60] font-medium">
                            {{ $huruf }}. {{ $text }}
                        </span>
                    </label>
                @endforeach

                <div class="flex justify-between mt-8">
                    @if ($nomor > 1)
                        <button type="submit" name="sebelumnya"
                            class="bg-[#1080CF] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#0b6cb2] transition">
                            &lt; Sebelumnya
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if ($nomor < count($pertanyaanList))
                        <button type="submit" name="selanjutnya"
                            class="bg-[#1080CF] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#0b6cb2] transition">
                            Selanjutnya &gt;
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL KONFIRMASI SELESAIKAN TES ===== --}}
<div id="confirmModal"
     class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-6 w-[90%] max-w-sm">
        
        <div class="text-center">
            <div class="text-2xl font-bold text-[#073B60]">
                Selesaikan Tes
            </div>
            <p class="text-gray-700 text-base mt-2 leading-relaxed">
                Apa kamu yakin ingin menyelesaikan tes?<br>
                Jawaban akan dikirim.
            </p>
        </div>

        <div class="flex justify-center gap-4 mt-6">
            <button id="btnCancel"
                class="px-6 py-2 border border-gray-400 rounded-xl font-semibold">
                Batal
            </button>

            <button id="btnSubmitFinish"
                class="px-6 py-2 bg-[#1080CF] text-white rounded-xl font-semibold">
                Selesai
            </button>
        </div>

    </div>
</div>


<script>
    let sisaDetik = Math.floor({{ $sisaDetik }});
    const timerElement = document.getElementById('timer');

    function updateTimer() {
        if (sisaDetik <= 0) {
            timerElement.textContent = "00:00";
            clearInterval(interval);
            alert("Waktu tes sudah habis. Jawaban akan disimpan otomatis.");
            window.location.href = "{{ route('tes.selesaikan', ['slug' => $slug]) }}";
            return;
        }

        const menit = Math.floor(sisaDetik / 60);
        const detik = sisaDetik % 60;
        timerElement.textContent =
            String(menit).padStart(2, '0') + ":" + String(detik).padStart(2, '0');

        sisaDetik--;
    }

    updateTimer();
    const interval = setInterval(updateTimer, 1000);


    // ===== LOGIC MODAL SUBMIT TES =====
    document.getElementById('btnConfirmFinish').addEventListener('click', function () {
        document.getElementById('confirmModal').classList.remove('hidden');
    });

    document.getElementById('btnCancel').addEventListener('click', function () {
        document.getElementById('confirmModal').classList.add('hidden');
    });

    document.getElementById('btnSubmitFinish').addEventListener('click', function () {
        document.querySelector('form[action="{{ route('tes.selesaikan', ['slug' => $slug]) }}"]').submit();
    });
</script>

@endsection
