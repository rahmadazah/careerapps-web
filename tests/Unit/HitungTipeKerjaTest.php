<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\HasilTes;

class HitungTipeKerjaTest extends TestCase
{
    /** @test */
    public function test_jawaban_kosong()
    {
        $jawaban = [
            1 => null
        ];

        $hasil = HasilTes::hitungTipeKerja($jawaban);

        $this->assertEquals(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_jawaban_tunggal_bukan_list_masuk_kategori()
    {
        $jawaban = [
            1 => 1
        ];

        $hasil = HasilTes::hitungTipeKerja($jawaban);

        $this->assertGreaterThan(0, $hasil['skor']['Realistic']);
    }

    /** @test */
    public function test_jawaban_sudah_berbentuk_list()
    {
        $jawaban = [
            5 => [1, 1]
        ];

        $hasil = HasilTes::hitungTipeKerja($jawaban);

        $this->assertEquals(2, $hasil['skor']['Artistic']);
    }

    /** @test */
    public function test_nomor_soal_tidak_masuk_kategori()
    {
        $jawaban = [
            99 => 1
        ];

        $hasil = HasilTes::hitungTipeKerja($jawaban);

        $this->assertEquals(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_beberapa_jawaban_diproses()
    {
        $jawaban = [
            1 => 1,
            3 => 1
        ];

        $hasil = HasilTes::hitungTipeKerja($jawaban);

        $this->assertGreaterThan(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_semua_jawaban_valid_dan_beragam()
    {
        $jawaban = [
            1 => 1,
            3 => [1,1],
            5 => 1,
            7 => null,
            99 => 1
        ];

        $hasil = HasilTes::hitungTipeKerja($jawaban);

        $this->assertArrayHasKey('kategori_teratas', $hasil);
    }
}
