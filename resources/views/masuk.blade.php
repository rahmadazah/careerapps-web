<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CareerApps</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body 
    class="bg-gray-100"
    x-data="{ showModal:false }"
>

<header class="bg-white fixed top-0 left-0 w-full h-16 shadow-sm flex items-center px-6 lg:px-16">
    <div class="text-3xl font-bold text-blue-900">CareerApps</div>
</header>

<main class="pt-20 px-10 lg:px-16">
    <div class="bg-white rounded-2xl shadow-xl flex flex-col lg:flex-row items-stretch overflow-hidden mb-4">

        <!-- LEFT (IMAGE TETAP ADA) -->
        <div class="lg:w-1/2 p-8 lg:p-16 flex flex-col items-center">
            <div class="w-1/2 max-w-xs sm:max-w-sm md:max-w-md aspect-auto relative overflow-hidden">
                <img src="{{ asset('images/login-main.png') }}" 
                     alt="" 
                     class="w-full h-full object-cover object-left-top">
            </div>

            <div class="w-full max-w-xl flex flex-col items-start gap-2">
                <h1 class="text-3xl text-[#073B60] font-bold leading-snug">
                    Kenali Dirimu Lebih Jauh,<br />Petakan Potensi Kariermu!
                </h1>
                <p class="text-base text-[#073B60] leading-relaxed">
                    Mengenali diri lebih jauh menggali lebih banyak potensi diri yang belum diketahui.
                </p>
                <p class="text-base text-[#073B60] leading-relaxed">
                    Yuk, cari tahu peluang kariermu!
                </p>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="lg:w-1/2 p-8 lg:p-16 flex flex-col items-center gap-4">
            <h2 class="text-3xl font-extrabold text-blue-900">Masuk</h2>

            {{-- VALIDASI KOSONG --}}
            @if ($errors->any())
                <div class="w-full p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- LOGIN GAGAL --}}
            @if (session('error'))
                <div class="w-full p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('masuk.submit') }}" class="w-full flex flex-col gap-4">
                @csrf

                <div class="flex flex-col gap-2">
                    <label class="text-base text-blue-900">Username or Email</label>
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <div class="p-4 bg-gray-200">
                            <img src="{{ asset('icons/email.png') }}" class="h-4 w-5" />
                        </div>
                        <input 
                            name="email"
                            type="text"
                            value="{{ old('email') }}"
                            class="flex-1 px-4 py-3 focus:outline-none"
                            placeholder="Masukkan email"/>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-base text-blue-900">Password</label>
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <div class="p-4 bg-gray-200">
                            <img src="{{ asset('icons/password.png') }}" class="h-4 w-5" />
                        </div>
                        <input 
                            name="password"
                            type="password"
                            class="flex-1 px-4 py-3 focus:outline-none"
                            placeholder="Masukkan password"/>
                    </div>
                </div>

                <button class="w-full py-4 bg-blue-900 text-white text-xl font-bold rounded-lg hover:bg-blue-800 transition">
                    Masuk
                </button>
            </form>

            <!-- LUPA PASSWORD -->
            <button 
                class="text-center text-blue-900 hover:underline"
                @click="showModal = true"
            >
                Lupa Kata Sandi?
            </button>
        </div>
    </div>
</main>

<!-- MODAL KONFIRMASI -->
<div 
    x-show="showModal"
    x-transition
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
>
    <div class="bg-white rounded-2xl p-6 w-[90%] max-w-sm" @click.outside="showModal=false">
        <div class="text-center">
            <div class="text-2xl font-bold">Konfirmasi</div>
            <p class="text-gray-700 mt-2">
                Kamu akan diarahkan ke halaman eksternal untuk mengubah kata sandi.
            </p>
        </div>

        <div class="flex justify-center gap-4 mt-6">
            <button 
                @click="showModal=false"
                class="px-6 py-2 border rounded-xl font-semibold">
                Batal
            </button>

            <a 
                href="https://bais.ub.ac.id/"
                class="px-6 py-2 bg-[#1080CF] text-white rounded-xl font-semibold">
                Lanjutkan
            </a>
        </div>
    </div>
</div>

</body>
</html>
