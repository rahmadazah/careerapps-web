@extends('layouts.app')

@section('title', $detailTes['title'])

@section('content')
    <div class="text-4xl font-bold text-black">{{ $detailTes['title'] }}</div>
    @if ($slug === 'tes-mbti')
        <div class="w-full flex justify-center">
            <div class="w-1/2 max-w-sm">
                <canvas id="mbtiChart" class="w-full"></canvas>
            </div>
        </div>
    @elseif ($slug === 'tes-preferensi-bakat')
        <div class="w-full flex justify-center">
            <div class="w-1/2 max-w-sm">
                <canvas id="bakatChart" class="w-full"></canvas>
            </div>
        </div>
    @elseif ($slug === 'tes-tipe-pekerjaan')
        <div class="w-full flex justify-center">
            <div class="w-1/2 max-w-sm">
                <canvas id="kerjaChart" class="w-full"></canvas>
            </div>
        </div>
    @endif
    <div class="w-full p-3 bg-white rounded-xl border border-[#E2E2E2]">
        @if($slug === 'tes-mbti')
            <div class="gap-2">
                <p class="text-2xl font-bold text-[#073B60]">{{ $hasilAkhir }}</p>
                <p class="text-[#F79B39] font-bold">{{ implode(', ', $mbtiMapping) }}</p>
            </div>
        @endif
        @if($slug === 'tes-preferensi-bakat')
            <div class="gap-2">
                <p class="text-2xl font-bold text-[#073B60]">{{ $hasilAkhir }}</p>
                <p class="text-[#F79B39] font-bold">Skor : {{ $skorUtama }}</p>
            </div>
        @endif
        @if($slug === 'tes-tipe-pekerjaan')
            <div class="gap-2">
                <p class="text-2xl font-bold text-[#073B60]">{{ $hasilAkhir }}</p>
                <p class="text-[#F79B39] font-bold">Skor : {{ $skorUtama }}</p>
            </div>
        @endif
        <p class="text-[#073B60] mt-2">{{ $penjelasanUtama }}</p>
        <div class="w-full flex justify-end mt-2">
            <a href="{{ route('tes.detail-hasil', $slug) }}" class="w-fit bg-[#1080CF] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#0d6faf]">
                Lihat Detail
            </a>
        </div>
    </div>
    <a href="{{ route('tes.detail', $slug) }}"
        class="w-full bg-[#1080CF] hover:bg-[#0c6bb0] transition text-white text-base font-semibold text-center py-3 rounded-lg">
        Kembali ke Detail Tes
    </a>

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
