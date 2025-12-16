@extends('layouts.app')

@section('title', 'Nama Lowongan Kerja')

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
    <div class="flex flex-col gap-4">
        <div class="w-full flex flex-col items-start gap-1">
            <div class="w-full text-black text-4xl font-bold leading-tight">{{ $lowonganKerja['title'] }}</div>
            <div class="w-full text-[#073B60] text-xl font-medium leading-tight">{{ $lowonganKerja['companyName'] }}</div>
        </div>

        <div class="w-1/4 rounded-xl border border-[#E2E2E2] overflow-hidden flex flex-col items-start p-2">
            <div class="overflow-hidden flex items-center gap-1">
                <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.83301 1.75C6.16453 1.75 6.48247 1.8817 6.71689 2.11612C6.95131 2.35054 7.08301 2.66848 7.08301 3H8.33301C8.55402 3 8.76598 3.0878 8.92226 3.24408C9.07854 3.40036 9.16634 3.61232 9.16634 3.83333V8.41667C9.16634 8.63768 9.07854 8.84964 8.92226 9.00592C8.76598 9.1622 8.55402 9.25 8.33301 9.25H1.66634C1.44533 9.25 1.23337 9.1622 1.07709 9.00592C0.920805 8.84964 0.833008 8.63768 0.833008 8.41667V3.83333C0.833008 3.61232 0.920805 3.40036 1.07709 3.24408C1.23337 3.0878 1.44533 3 1.66634 3H2.91634C2.91634 2.66848 3.04804 2.35054 3.28246 2.11612C3.51688 1.8817 3.83482 1.75 4.16634 1.75H5.83301ZM7.91634 4.66667H2.08301C1.97681 4.66678 1.87466 4.70745 1.79744 4.78035C1.72021 4.85326 1.67374 4.9529 1.66752 5.05891C1.6613 5.16493 1.69579 5.26932 1.76395 5.35076C1.83211 5.4322 1.9288 5.48454 2.03426 5.49708L2.08301 5.5H4.58301V5.91667C4.58313 6.02287 4.62379 6.12501 4.69669 6.20224C4.7696 6.27946 4.86924 6.32593 4.97526 6.33216C5.08127 6.33838 5.18567 6.30389 5.2671 6.23572C5.34854 6.16756 5.40088 6.07087 5.41342 5.96542L5.41634 5.91667V5.5H7.91634C8.02254 5.49988 8.12469 5.45922 8.20191 5.38631C8.27913 5.31341 8.32561 5.21377 8.33183 5.10775C8.33805 5.00173 8.30356 4.89734 8.2354 4.8159C8.16723 4.73446 8.07055 4.68213 7.96509 4.66958L7.91634 4.66667ZM5.83301 2.58333H4.16634C4.06429 2.58335 3.96578 2.62081 3.88952 2.68863C3.81325 2.75645 3.76453 2.8499 3.75259 2.95125L3.74967 3H6.24967C6.24966 2.89794 6.21219 2.79944 6.14438 2.72318C6.07656 2.64691 5.98311 2.59819 5.88176 2.58625L5.83301 2.58333Z" fill="#073B60"/>
                </svg>
                <div class="text-[#073B60] text-base font-normal">{{ $lowonganKerja['status'] }}</div>
            </div>
            <div class="overflow-hidden flex items-center gap-1">
                <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.00036 1.33334C3.16244 1.33334 1.66703 2.82876 1.66703 4.66459C1.65494 7.35001 4.87369 9.57668 5.00036 9.66668C5.00036 9.66668 8.34578 7.35001 8.33369 4.66668C8.33369 2.82876 6.83828 1.33334 5.00036 1.33334ZM5.00036 6.33334C4.07953 6.33334 3.33369 5.58751 3.33369 4.66668C3.33369 3.74584 4.07953 3.00001 5.00036 3.00001C5.92119 3.00001 6.66703 3.74584 6.66703 4.66668C6.66703 5.58751 5.92119 6.33334 5.00036 6.33334Z" fill="#073B60"/>
                </svg>
                <div class="text-[#073B60] text-base font-normal">{{ $lowonganKerja['location'] }}</div>
            </div>
            <div class="overflow-hidden flex items-center gap-1">
                <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_772_1609)">
                    <path d="M5.00033 5.70834C4.61355 5.70834 4.24262 5.86199 3.96913 6.13548C3.69564 6.40897 3.54199 6.7799 3.54199 7.16668C3.54199 7.55345 3.69564 7.92438 3.96913 8.19787C4.24262 8.47136 4.61355 8.62501 5.00033 8.62501C5.3871 8.62501 5.75803 8.47136 6.03152 8.19787C6.30501 7.92438 6.45866 7.55345 6.45866 7.16668C6.45866 6.7799 6.30501 6.40897 6.03152 6.13548C5.75803 5.86199 5.3871 5.70834 5.00033 5.70834ZM4.37533 7.16668C4.37533 7.00092 4.44117 6.84195 4.55838 6.72474C4.67559 6.60752 4.83457 6.54168 5.00033 6.54168C5.16609 6.54168 5.32506 6.60752 5.44227 6.72474C5.55948 6.84195 5.62533 7.00092 5.62533 7.16668C5.62533 7.33244 5.55948 7.49141 5.44227 7.60862C5.32506 7.72583 5.16609 7.79168 5.00033 7.79168C4.83457 7.79168 4.67559 7.72583 4.55838 7.60862C4.44117 7.49141 4.37533 7.33244 4.37533 7.16668Z" fill="#084169"/>
                    <path d="M7.3025 2.63168L5.97792 0.774597L1.1075 4.66543L0.8375 4.66251V4.66668H0.625V9.66668H9.375V4.66668H8.97417L8.17667 2.33376L7.3025 2.63168ZM8.09375 4.66668H3.91542L7.0275 3.60585L7.66167 3.40293L8.09375 4.66668ZM6.47917 2.91251L3.26667 4.00751L5.81083 1.97501L6.47917 2.91251ZM1.45833 8.07043V6.2621C1.63424 6.20001 1.79402 6.09935 1.92596 5.96748C2.0579 5.83561 2.15865 5.67589 2.22083 5.50001H7.77917C7.84129 5.67596 7.94202 5.83577 8.07397 5.96771C8.20591 6.09966 8.36572 6.20039 8.54167 6.26251V8.07085C8.36572 8.13297 8.20591 8.2337 8.07397 8.36565C7.94202 8.49759 7.84129 8.6574 7.77917 8.83335H2.22167C2.15924 8.65738 2.05832 8.49757 1.92626 8.36558C1.7942 8.23359 1.63433 8.13276 1.45833 8.07043Z" fill="#084169"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_772_1609">
                    <rect width="10" height="10" fill="white" transform="translate(0 0.5)"/>
                    </clipPath>
                    </defs>
                </svg>
                <div class="text-[#073B60] text-base font-normal">{{ $lowonganKerja['salaries'] }}</div>
            </div>
            <div class="overflow-hidden flex items-center gap-1">
                <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.00033 0.75L0.416992 3.25L2.08366 4.15833V6.65833L5.00033 8.25L7.91699 6.65833V4.15833L8.75032 3.70417V6.58333H9.58366V3.25L5.00033 0.75ZM7.84199 3.25L5.00033 4.8L2.15866 3.25L5.00033 1.7L7.84199 3.25ZM7.08366 6.16667L5.00033 7.3L2.91699 6.16667V4.6125L5.00033 5.75L7.08366 4.6125V6.16667Z" fill="#084169"/>
                </svg>
                <div class="text-[#073B60] text-base font-normal">{{ $lowonganKerja['graduates'] }}</div>
            </div>
        </div>

        {{-- <div class="w-full bg-[#1080CF] rounded-lg flex flex-col items-start p-3">
            <div class="text-white text-base font-normal leading-snug">Profilmu 85% cocok dengan posisi ini!</div>
        </div> --}}

        <div class="w-full flex flex-col items-center">
            <img class="w-1/2" src="{{ $lowonganKerja['banner'] }}" alt="Lowongan Kerja">
        </div>

        <div class="w-full flex flex-col items-start gap-1 border border-gray-200 rounded-lg">
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Deskripsi</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganKerja['descriptions'])) !!}</div>
            </div>
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Tanggung Jawab</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganKerja['responsibilities'])) !!}</div>
            </div>
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Persyaratan</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganKerja['requirements'])) !!}</div>
            </div>
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Pengalaman Kerja</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganKerja['experiences'])) !!}</div>
            </div>
            <div class="w-full p-2 flex items-start flex-col gap-1">
                <div class="text-[#073B60] text-base font-bold leading-tight">Manfaat</div>
                <div class="text-[#073B60] text-base font-normal leading-snug">{!! nl2br(e($lowonganKerja['benefits'])) !!}</div>
            </div>
        </div>

        <button class="w-full bg-[#1080CF] text-white text-base font-normal leading-snug rounded-lg flex flex-col items-center p-3 hover:bg-[#0d6faf]"
            @click="externalUrl = '{{ $lowonganKerja['registration'] }}'; showModal = true;">Daftar Sekarang
        </button>
    </div>
</div>
@endsection