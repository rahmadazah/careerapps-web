<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\HasilTes;

class HitungMBTITest extends TestCase
{
    /** @test */
    public function test_semua_jawaban_a()
    {
        $jawaban = array_fill(1, 28, 'A');

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertArrayHasKey('tipe_teratas', $hasil);
        $this->assertEquals(28, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_jawaban_kosong()
    {
        $jawaban = [];

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertEquals(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_semua_jawaban_b()
    {
        $jawaban = array_fill(1, 28, 'B');

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertArrayHasKey('tipe_teratas', $hasil);
    }

    /** @test */
    public function test_jawaban_tidak_valid()
    {
        $jawaban = array_fill(1, 28, 'C');

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertEquals(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_skor_seri()
    {
        $jawaban = [
            1=>'A',2=>'A',3=>'A',
            4=>'B',5=>'B',6=>'B'
        ];

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertContains(
            $hasil['tipe_teratas'][0],
            ['E','I']
        );
    }

    /** @test */
    public function test_skor_tidak_seri()
    {
        $jawaban = [
            1=>'B',2=>'B',3=>'B',
            4=>'A',5=>'A',6=>'A',7=>'B'
        ];

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertContains(
            $hasil['tipe_teratas'][0],
            ['E','I']
        );
    }

    /** @test */
    public function test_sebagian_jawaban_ada()
    {
        $jawaban = [
            1 => 'A',
            2 => 'B'
        ];

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertGreaterThan(0, array_sum($hasil['skor']));
    }

    /** @test */
    public function test_campuran_a_b_kosong()
    {
        $jawaban = [
            1 => 'A',
            2 => 'B',
            3 => null,
            4 => 'C'
        ];

        $hasil = HasilTes::hitungMBTI($jawaban);

        $this->assertIsArray($hasil);
    }
}
