@extends('layouts.app')

@section('title', 'Lowongan Kerja')

@section('content')
    <h1 class="w-full text-black text-3xl font-bold leading-tight">Lowongan Kerja</h1>
    <div class="w-full flex flex-col md:flex-row justify-between items-center gap-3">
        <div class="flex gap-2 text-sm items-center flex-wrap">
            <span class="text-[#073B60]">Filter</span>
            <a href="{{ route('kerja') }}"
                class="p-2 rounded-lg {{ empty($status) ? 'bg-[#1080CF] text-white' : 'bg-white text-[#777] border border-[#777]' }}">
                Terbaru
            </a>
            <a href="{{ route('kerja', ['status' => 'fulltime', 'keyword' => request('keyword')]) }}"
                class="p-2 rounded-lg {{ $status === 'fulltime' ? 'bg-[#1080CF] text-white' : 'bg-white text-[#777] border border-[#777]' }}">
                Fulltime
            </a>
            <a href="{{ route('kerja', ['status' => 'parttime', 'keyword' => request('keyword')]) }}"
                class="p-2 rounded-lg {{ $status === 'parttime' ? 'bg-[#1080CF] text-white' : 'bg-white text-[#777] border border-[#777]' }}">
                Parttime
            </a>
            <a href="{{ route('kerja', ['status' => 'internship', 'keyword' => request('keyword')]) }}"
                class="p-2 rounded-lg {{ $status === 'internship' ? 'bg-[#1080CF] text-white' : 'bg-white text-[#777] border border-[#777]' }}">
                Internship
            </a>
        </div>

        <form method="GET" class="flex items-center gap-2 text-sm">
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Masukkan kata kunci"
                class="p-2 px-3 border border-[#777] text-[#777] rounded-lg focus:outline-none focus:border-[#1080CF]"/>

            @if ($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif

            <button class="p-2 px-3 bg-[#1080CF] text-white rounded-lg">
                Cari
            </button>
        </form>
    </div>
    
    @if ($daftarLowonganKerja->isEmpty())
        <p class="flex justify-center items-center w-full h-full text-center text-gray-500">
            Belum ada lowongan kerja yang tersedia.
        </p>
    @else
        <ul class="w-full flex flex-col gap-4">
            @foreach ($daftarLowonganKerja as $lowonganKerja)
                <li>
                    <a href="{{ route('kerja.detail', $lowonganKerja['slug']) }}" class="w-full p-4 bg-white rounded-xl border border-[#E2E2E2] flex flex-row items-center gap-5">
                        <div class="w-20 h-20 overflow-hidden flex items-center justify-center">
                            <img class="max-w-full max-h-full object-contain" src="{{ $lowonganKerja['icon_company'] }}" />
                        </div>                
                        <div class="flex flex-col items-start rounded gap-1">
                            <div class="w-full text-xl font-bold">{{ $lowonganKerja['title'] }}</div>
                            <div class="w-full text-base font-medium">{{ $lowonganKerja['companyName'] }}</div>
                            <div class="w-full overflow-hidden flex items-center gap-1">
                                <div class="h-4 overflow-hidden flex items-center gap-1">
                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.83301 1.75C6.16453 1.75 6.48247 1.8817 6.71689 2.11612C6.95131 2.35054 7.08301 2.66848 7.08301 3H8.33301C8.55402 3 8.76598 3.0878 8.92226 3.24408C9.07854 3.40036 9.16634 3.61232 9.16634 3.83333V8.41667C9.16634 8.63768 9.07854 8.84964 8.92226 9.00592C8.76598 9.1622 8.55402 9.25 8.33301 9.25H1.66634C1.44533 9.25 1.23337 9.1622 1.07709 9.00592C0.920805 8.84964 0.833008 8.63768 0.833008 8.41667V3.83333C0.833008 3.61232 0.920805 3.40036 1.07709 3.24408C1.23337 3.0878 1.44533 3 1.66634 3H2.91634C2.91634 2.66848 3.04804 2.35054 3.28246 2.11612C3.51688 1.8817 3.83482 1.75 4.16634 1.75H5.83301ZM7.91634 4.66667H2.08301C1.97681 4.66678 1.87466 4.70745 1.79744 4.78035C1.72021 4.85326 1.67374 4.9529 1.66752 5.05891C1.6613 5.16493 1.69579 5.26932 1.76395 5.35076C1.83211 5.4322 1.9288 5.48454 2.03426 5.49708L2.08301 5.5H4.58301V5.91667C4.58313 6.02287 4.62379 6.12501 4.69669 6.20224C4.7696 6.27946 4.86924 6.32593 4.97526 6.33216C5.08127 6.33838 5.18567 6.30389 5.2671 6.23572C5.34854 6.16756 5.40088 6.07087 5.41342 5.96542L5.41634 5.91667V5.5H7.91634C8.02254 5.49988 8.12469 5.45922 8.20191 5.38631C8.27913 5.31341 8.32561 5.21377 8.33183 5.10775C8.33805 5.00173 8.30356 4.89734 8.2354 4.8159C8.16723 4.73446 8.07055 4.68213 7.96509 4.66958L7.91634 4.66667ZM5.83301 2.58333H4.16634C4.06429 2.58335 3.96578 2.62081 3.88952 2.68863C3.81325 2.75645 3.76453 2.8499 3.75259 2.95125L3.74967 3H6.24967C6.24966 2.89794 6.21219 2.79944 6.14438 2.72318C6.07656 2.64691 5.98311 2.59819 5.88176 2.58625L5.83301 2.58333Z" fill="#073B60"/>
                                    </svg>
                                    <div class="text-[#073B60] text-xs font-normal">{{ $lowonganKerja['status'] }}</div>
                                </div>
                                <div class="h-4 overflow-hidden flex items-center gap-1">
                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.00036 1.33334C3.16244 1.33334 1.66703 2.82876 1.66703 4.66459C1.65494 7.35001 4.87369 9.57668 5.00036 9.66668C5.00036 9.66668 8.34578 7.35001 8.33369 4.66668C8.33369 2.82876 6.83828 1.33334 5.00036 1.33334ZM5.00036 6.33334C4.07953 6.33334 3.33369 5.58751 3.33369 4.66668C3.33369 3.74584 4.07953 3.00001 5.00036 3.00001C5.92119 3.00001 6.66703 3.74584 6.66703 4.66668C6.66703 5.58751 5.92119 6.33334 5.00036 6.33334Z" fill="#073B60"/>
                                    </svg>
                                    <div class="text-[#073B60] text-xs font-normal">{{ $lowonganKerja['location'] }}</div>
                                </div>
                            </div>
                            <div class="w-full text-[#777] text-xs font-normal">{{ $lowonganKerja['createdAt'] }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="w-full flex items-center justify-center gap-2 select-none">
            @if ($currentPage > 1)
                <a href="?page={{ $currentPage - 1 }}&status={{ $status }}&search={{ $search }}"
                    class="w-8 h-8 bg-white border rounded-xl shadow-sm hover:bg-blue-50 transition text-gray-600 flex justify-center items-center gap-1">
                    <
                </a>
            @endif

            @for ($i = 1; $i <= $totalPages; $i++)
                <a href="?page={{ $i }}&status={{ $status }}&search={{ $search }}"
                    class="w-8 h-8 flex items-center justify-center rounded-xl 
                        {{ $i == $currentPage 
                            ? 'bg-blue-600 text-white shadow-md scale-[1.05]' 
                            : 'bg-white text-gray-600 border hover:bg-blue-50' }}
                        transition">
                    {{ $i }}
                </a>
            @endfor

            @if ($currentPage < $totalPages)
                <a href="?page={{ $currentPage + 1 }}&status={{ $status }}&search={{ $search }}"
                    class="w-8 h-8 bg-white border rounded-xl shadow-sm hover:bg-blue-50 transition text-gray-600 flex justify-center items-center gap-1">
                    >
                </a>
            @endif

        </div>
    @endif
@endsection