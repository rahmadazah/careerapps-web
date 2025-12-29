<?php


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PengelolaAkademik;
use App\Http\Controllers\PengelolaAutentikasi;
use App\Http\Controllers\PengelolaDashboard;
use App\Http\Controllers\PengelolaHardskill;
use App\Http\Controllers\PengelolaHasilTes;
use App\Http\Controllers\PengelolaKegiatan;
use App\Http\Controllers\PengelolaKemahasiswaan;
use App\Http\Controllers\PengelolaLowonganBeasiswa;
use App\Http\Controllers\PengelolaLowonganKerja;
use App\Http\Controllers\PengelolaLowonganMagang;
use App\Http\Controllers\PengelolaProfil;
use App\Http\Controllers\PengelolaSoftskill;
use App\Http\Controllers\PengelolaTes;

Route::get('/', function () {
    return view('masuk');
});

Route::middleware(['web'])->group(function () {
    Route::get('/cek', function () {
        dd(Session::all());
    });

    Route::get('/masuk', [PengelolaAutentikasi::class, 'tampilkanHalamanMasuk'])->name('masuk');
    Route::post('/masuk', [PengelolaAutentikasi::class, 'masuk'])->name('masuk.submit');
    Route::post('/keluar', [PengelolaAutentikasi::class, 'keluar'])->name('keluar');

    Route::get('/profil', [PengelolaProfil::class, 'tampilkanProfil'])->name('profil');
    Route::get('/ubah-kata-sandi', [PengelolaProfil::class, 'ubahKataSandi'])->name('ubah.katasandi');

    Route::get('/dashboard', [PengelolaDashboard::class, 'tampilkanDashboard'])->name('dashboard');

    Route::get('/hardskill', [PengelolaHardskill::class, 'tampilkanSemua'])->name('dashboard.hardskill');
    Route::get('/mk-relevan/{slug}', [PengelolaHardskill::class, 'tampilkanDetailMKRelevan'])->name('dashboard.relevan');
    Route::get('/mk-rekomendasi/{slug}', [PengelolaHardskill::class, 'tampilkanDetailMKRekomendasi'])->name('dashboard.rekomendasi');

    Route::get('/softskill', [PengelolaSoftskill::class, 'index'])->name('dashboard.softskill');

    Route::get('/tes', [PengelolaTes::class, 'tampilkanDaftarTes'])->name('tes.daftar');
    Route::get('/tes/{slug}', [PengelolaTes::class, 'tampilkanDetailTes'])->name('tes.detail');
    Route::get('/tes/{slug}/persetujuan', [PengelolaTes::class, 'tampilkanPersetujuanPengguna'])->name('tes.persetujuan');
    Route::post('/tes/{slug}/mulai', [PengelolaTes::class, 'mulaiTes'])->name('tes.mulai');
    Route::get('/tes/{slug}/soal/{nomor}', [PengelolaTes::class, 'tampilkanSoal'])->name('tes.soal');
    Route::post('/tes/simpan-jawaban', [PengelolaTes::class, 'simpanJawaban'])->name('tes.simpan');
    Route::get('/tes/{slug}/selesaikan', [PengelolaTes::class, 'selesaikanTes'])->name('tes.selesaikan');
    Route::get('/tes/{slug}/hasil', [PengelolaHasilTes::class, 'tampilkanHasilTes'])->name('tes.hasil');
    Route::get('/tes/{slug}/hasil/detail', [PengelolaHasilTes::class, 'tampilkanDetailHasilTes'])->name('tes.detail-hasil');

    Route::get('/informasi-akademik', [PengelolaAkademik::class, 'tampilkanSemua'])->name('akademik');
    Route::get('/informasi-akademik/khs/semester/{semester}', [PengelolaAkademik::class, 'tampilkanKHS'])->name('akademik.khs');

    Route::get('/informasi-kemahasiswaan', [PengelolaKemahasiswaan::class, 'tampilkanHalaman'])->name('kemahasiswaan');

    Route::get('/lowongan-kerja', [PengelolaLowonganKerja::class, 'tampilkanSemua'])->name('kerja');
    Route::get('/lowongan-kerja/{slug}', [PengelolaLowonganKerja::class, 'tampilkanDetail'])->name('kerja.detail');

    Route::get('/lowongan-magang', [PengelolaLowonganMagang::class, 'tampilkanSemua'])->name('magang');
    Route::get('/lowongan-magang/{slug}', [PengelolaLowonganMagang::class, 'tampilkanDetail'])->name('magang.detail');

    Route::get('/lowongan-beasiswa', [PengelolaLowonganBeasiswa::class, 'tampilkanSemua'])->name('beasiswa');
    Route::get('/lowongan-beasiswa/{slug}', [PengelolaLowonganBeasiswa::class, 'tampilkanDetail'])->name('beasiswa.detail');

    Route::get('/kegiatan', [PengelolaKegiatan::class, 'tampilkanSemua'])->name('kegiatan');
    Route::get('/kegiatan/{slug}', [PengelolaKegiatan::class, 'tampilkanDetail'])->name('kegiatan.detail');

});

Route::get('/cek-session', function () {
    if (!session()->has('test')) {
        session(['test' => now()]);
    }
    return 'Session test: ' . session('test');
});