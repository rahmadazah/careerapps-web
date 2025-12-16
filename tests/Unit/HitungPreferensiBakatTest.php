<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\HasilTes;

class HitungPreferensiBakatTest extends TestCase
{
    /** @test */
    public function test_jawaban_kosong()
    {
        $jawaban = [
            1 => null
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertEquals(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_jawaban_tunggal_pilihan_a()
    {
        $jawaban = [
            0 => 'a'
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertGreaterThan(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_jawaban_tunggal_pilihan_b()
    {
        $jawaban = [
            1 => 'b'
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertGreaterThan(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_jawaban_tunggal_pilihan_c()
    {
        $jawaban = [
            2 => 'c'
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertGreaterThan(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_nomor_soal_tidak_masuk_kategori()
    {
        $jawaban = [
            99 => 'a'
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertEquals(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_loop_kategori_selesai_tanpa_kecocokan()
    {
        $jawaban = [
            50 => 'b'
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertEquals(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_beberapa_jawaban_diproses()
    {
        $jawaban = [
            0 => 'a',
            1 => 'b'
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertGreaterThan(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_kombinasi_jawaban_valid_dan_kosong()
    {
        $jawaban = [
            0 => null,
            1 => 'a'
        ];

        $hasil = HasilTes::hitungPreferensiBakat($jawaban);

        $this->assertIsArray($hasil);
        $this->assertArrayHasKey('kategori_terbawah', $hasil);
    }
}
