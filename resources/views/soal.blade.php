@extends('layouts.app')

@section('title', 'Soal Tes')

@section('content')
<div class="flex flex-col lg:flex-row gap-6">

    {{-- ================= SIDEBAR ================= --}}
    <div class="w-full lg:w-1/4 bg-white rounded-2xl border border-gray-200 p-4 flex flex-col items-center gap-4">

        <div id="timer"
            class="bg-[#FF9300] text-white text-lg font-bold px-6 py-2 rounded-xl text-center w-full">
            {{ floor($sisaDetik / 60) }}:{{ str_pad($sisaDetik % 60, 2, '0', STR_PAD_LEFT) }}
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

        {{-- TOMBOL SELESAI (SIDEBAR, BUKAN FORM) --}}
        @if ($nomor == count($pertanyaanList))
            <button type="button" id="btnConfirmFinish"
                class="bg-[#1080CF] text-white font-bold px-6 py-2 rounded-xl w-full mt-4">
                Selesai
            </button>
        @endif

    </div>

    {{-- ================= KONTEN SOAL ================= --}}
    <div class="flex-1 bg-white flex flex-col justify-between">

        {{-- SATU-SATUNYA FORM --}}
        <form id="formTes" action="{{ route('tes.simpan') }}" method="POST">
            @csrf
            <input type="hidden" name="nomor" value="{{ $nomor }}">

            <div>
                <h2 class="text-[#073B60] font-semibold mb-4 text-lg">
                    Soal {{ $nomor }}
                </h2>

                <p class="text-[#073B60] mb-6 leading-relaxed">
                    {{ $pertanyaan['questionText'] }}
                </p>

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
            </div>

            {{-- NAVIGASI --}}
            <div class="flex justify-between mt-8">
                @if ($nomor > 1)
                    <button type="submit" name="sebelumnya"
                        class="bg-[#1080CF] text-white px-4 py-2 rounded-lg font-bold">
                        &lt; Sebelumnya
                    </button>
                @else
                    <div></div>
                @endif

                @if ($nomor < count($pertanyaanList))
                    <button type="submit" name="selanjutnya"
                        class="bg-[#1080CF] text-white px-4 py-2 rounded-lg font-bold">
                        Selanjutnya &gt;
                    </button>
                @endif
            </div>

        </form>
    </div>
</div>

{{-- ================= MODAL KONFIRMASI ================= --}}
<div id="confirmModal"
     class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-6 w-[90%] max-w-sm text-center">
        <h2 class="text-2xl font-bold text-[#073B60]">Selesaikan Tes</h2>
        <p class="text-gray-700 mt-2">
            Apa kamu yakin ingin menyelesaikan tes?
        </p>

        <div class="flex justify-center gap-4 mt-6">
            <button id="btnCancel"
                class="px-6 py-2 border rounded-xl font-semibold">
                Batal
            </button>

            {{-- INI YANG PENTING --}}
            <button
                type="submit"
                name="selesai"
                form="formTes"
                class="px-6 py-2 bg-[#1080CF] text-white rounded-xl font-semibold">
                Selesai
            </button>
        </div>
    </div>
</div>

<script>
    // ===== TIMER =====
    let sisaDetik = Math.floor({{ $sisaDetik }});
    const timer = document.getElementById('timer');

    function updateTimer() {
        if (sisaDetik <= 0) {
            alert('Waktu habis. Jawaban akan disimpan.');
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selesai';
            input.value = '1';
            document.getElementById('formTes').appendChild(input);
            document.getElementById('formTes').submit();
            return;
        }

        const m = Math.floor(sisaDetik / 60);
        const d = sisaDetik % 60;
        timer.textContent = String(m).padStart(2, '0') + ':' + String(d).padStart(2, '0');
        sisaDetik--;
    }

    setInterval(updateTimer, 1000);

    // ===== MODAL =====
    document.getElementById('btnConfirmFinish')?.addEventListener('click', () => {
        document.getElementById('confirmModal').classList.remove('hidden');
    });

    document.getElementById('btnCancel').addEventListener('click', () => {
        document.getElementById('confirmModal').classList.add('hidden');
    });
</script>
@endsection
