@extends('layouts.app')

@section('title', $detailTes['title'])

@section('content')

@if(session('error'))
    <div class="p-3 bg-red-200 text-red-800 rounded mb-3">
        {{ session('error') }}
    </div>
@endif


<div class="w-full flex flex-col items-start gap-2">
    <div class="flex flex-row gap-2 items-center mb-4">
        @if ($slug === 'tes-mbti')
            <img class="w-9 h-9" src="{{ asset('icons/mbti.png') }}" alt="mbti"/>
        @elseif ($slug === 'tes-preferensi-bakat')
            <img class="w-9 h-9" src="{{ asset('icons/bakat.png') }}" alt="bakat"/>
        @elseif ($slug === 'tes-tipe-pekerjaan')
            <img class="w-9 h-9" src="{{ asset('icons/kerja.png') }}" alt="kerja"/>
        @endif
        <div class="text-black text-4xl font-bold leading-tight">
            {{ $detailTes['title'] }}
        </div>
    </div>
</div>
@if ($slug === 'tes-mbti' && !empty($detail))
    <div class="w-full flex justify-center">
        <div class="w-1/2 max-w-sm">
            <canvas id="mbtiChart" class="w-full"></canvas>
        </div>
    </div>
    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Semakin tinggi nilai, semakin sesuai dengan sesuai dengan tipe MBTI kamu.</span></div>
    </div>
    <div class="w-full p-4 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">
        <div class="text-[#073B60] text-xl font-bold leading-tight">
            {{ $detail['tipe']['kode'] }}
        </div>
        <div class="text-[#F79B39] font-bold leading-snug">
            {{ implode(', ', $mbtiMapping) }}
        </div>
        <div class="text-[#073B60] text-base font-normal leading-snug">
            {{ $detail['tipe']['penjelasan'] }}
        </div>
    </div>
    <div class="w-full flex flex-col items-start gap-4">
        @foreach ($detail['dimensi'] as $nama => $row)
            <div class="w-full p-4 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">
                <div class="text-[#073B60] text-xl font-bold leading-tight">{{ $nama }} ({{ $row['huruf'] }})</div>
                <div class="text-[#F79B39] text-sm font-medium leading-snug">Skor: {{ $row['skor'] }}</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{{ $row['penjelasan'] }}</div>
            </div>
        @endforeach
    </div>

@elseif ($slug === 'tes-preferensi-bakat' && !empty($detail))
    <div class="w-full flex justify-center">
        <div class="w-1/2 max-w-sm">
            <canvas id="bakatChart" class="w-full"></canvas>
        </div>
    </div>

    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Semakin rendah nilai, semakin sesuai dengan preferensi bakatmu.</span></div>
    </div>
    <div class="w-full flex flex-col items-start gap-4">
        @foreach ($detail as $nama => $row)
            <div class="w-full p-4 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">
                <div class="text-[#073B60] text-xl font-bold leading-tight">{{ $nama }}</div>
                <div class="text-[#F79B39] text-sm font-medium leading-snug">Skor: {{ $row['skor'] }}</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{{ $row['penjelasan'] }}</div>
            </div>
        @endforeach
    </div>

@elseif ($slug === 'tes-tipe-pekerjaan' && !empty($detail))
    <div class="w-full flex justify-center">
        <div class="w-1/2 max-w-sm">
            <canvas id="kerjaChart" class="w-full"></canvas>
        </div>
    </div>
    <div class="w-full bg-[#F79B39] rounded-lg flex flex-col items-start gap-3 p-3">
        <div class="text-white text-base font-bold leading-snug">Perhatian: <span class="font-normal">Semakin tinggi nilai, semakin sesuai dengan tipe pekerjaanmu.</span></div>
    </div>
    <div class="w-full flex flex-col items-start gap-4">
        @foreach ($detail as $nama => $row)
            <div class="w-full p-4 bg-white rounded-lg border border-gray-200 flex flex-col gap-1">
                <div class="text-[#073B60] text-xl font-bold leading-tight">{{ $nama }}</div>
                <div class="text-[#F79B39] text-sm font-medium leading-snug">Skor: {{ $row['skor'] }}</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{{ $row['penjelasan'] }}</div>
            </div>
        @endforeach
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const slug = "{{ $slug }}";

    let canvasId = null;
    let labels = [];
    let chartType = "bar";
    let datasets = [];

    @if ($slug === 'tes-mbti')
        canvasId = "mbtiChart";

        const skor = {!! json_encode($skor) !!};

        const leftNames = ["E", "N", "T", "J"];
        const rightNames = ["I", "S", "F", "P"];

        labels = ["Extrovert - Introvert", "Intuitive - Sensing", "Thinking - Feeling", "Judging - Perceiving"];

        const leftValues = [skor["E"], skor["N"], skor["T"], skor["J"]];
        const rightValues = [skor["I"], skor["S"], skor["F"], skor["P"]];

        datasets = [
            { data: leftValues, backgroundColor: "#F79B39" },
            { data: rightValues, backgroundColor: "#1080CF" }
        ];

        chartType = "bar";

        // Plugin label bar
        const labelInsideBar = {
            id: "labelInsideBar",
            afterDatasetsDraw(chart) {
                const { ctx } = chart;

                chart.data.datasets.forEach((dataset, dIndex) => {
                    const meta = chart.getDatasetMeta(dIndex);

                    meta.data.forEach((bar, i) => {
                        const text = dIndex === 0 ? leftNames[i] : rightNames[i];

                        ctx.save();
                        ctx.fillStyle = "white";
                        ctx.font = "bold 12px sans-serif";
                        ctx.textAlign = "center";
                        ctx.textBaseline = "middle";
                        ctx.fillText(text, bar.x + (dIndex === 0 ? -20 : 20), bar.y);
                        ctx.restore();
                    });
                });
            }
        };
    @endif



    // ============================
    // 2) Preferensi Bakat / Tipe Pekerjaan (RADAR)
    // ============================
    @if ($slug === 'tes-preferensi-bakat' || $slug === 'tes-tipe-pekerjaan')
        canvasId = "{{ $slug === 'tes-preferensi-bakat' ? 'bakatChart' : 'kerjaChart' }}";

        labels = {!! json_encode(array_keys($detail)) !!};
        const nilai = {!! json_encode(array_column($detail, 'skor')) !!};

        datasets = [
            {
                data: nilai,
                backgroundColor: "rgba(17, 96, 122, 0.3)",
                borderColor: "#11607A",
                borderWidth: 2,
                pointBackgroundColor: "#11607A",
            }
        ];

        chartType = "radar";
    @endif




    // ============================
    // RENDER CHART
    // ============================
    if (canvasId) {
        const ctx = document.getElementById(canvasId).getContext("2d");

        const chartConfig = {
            type: chartType,
            data: {
                labels,
                datasets,
            },
            options: {
                plugins: { legend: { display: false } },
                scales: chartType === "bar"
                    ? {
                        x: { stacked: true, beginAtZero: true },
                        y: { stacked: true, beginAtZero: true },
                    }
                    : {},
            },
        };

        // Tambah plugin cuma untuk MBTI
        if (slug === "tes-mbti") {
            chartConfig.plugins = [labelInsideBar];
            chartConfig.options.indexAxis = "y";
        }

        new Chart(ctx, chartConfig);
    }
</script>




@endsection
