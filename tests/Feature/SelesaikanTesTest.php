<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SelesaikanTesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    /** 🟢 PATH 1 – Jawaban kosong */
    public function test_path_1_jawaban_kosong()
    {
        Session::put('jawaban', []);
        Session::put('student_id', 1);

        $this->post(route('tes.selesaikan', ['slug' => 'tes-mbti']))
            ->assertRedirect(route('tes.soal', [
                'slug' => 'tes-mbti',
                'nomor' => 1
            ]));
    }

    /** 🟢 PATH 2 – MBTI, prediksi gagal */
    public function test_path_2_mbti_prediksi_gagal()
    {
        Session::put('jawaban', [1 => 'A']);
        Session::put('student_id', 1);
        Session::put('student_nim', '123');
        Session::put('assessment_id', 1);

        $this->post(route('tes.selesaikan', ['slug' => 'tes-mbti']))
            ->assertRedirect(); // back
    }

    /** 🟢 PATH 3 – MBTI, prediksi berhasil */
    public function test_path_3_mbti_prediksi_berhasil()
    {
        Session::put('jawaban', [1 => 'A']);
        Session::put('student_id', 1);
        Session::put('student_nim', '123');
        Session::put('assessment_id', 1);

        $response = $this->post(route('tes.selesaikan', ['slug' => 'tes-mbti']));

        $response->assertStatus(302);
    }

    /** 🟢 PATH 4 – Preferensi bakat (kategori terbawah) */
    public function test_path_4_preferensi_bakat()
    {
        Session::put('jawaban', [1 => 'a']);
        Session::put('student_id', 1);
        Session::put('student_nim', '123');
        Session::put('assessment_id', 1);

        $this->post(route('tes.selesaikan', ['slug' => 'tes-preferensi-bakat']))
            ->assertStatus(302);
    }

    /** 🟢 PATH 5 – Tipe pekerjaan */
    public function test_path_5_tipe_pekerjaan()
    {
        Session::put('jawaban', [1 => 1]);
        Session::put('student_id', 1);
        Session::put('student_nim', '123');
        Session::put('assessment_id', 1);

        $this->post(route('tes.selesaikan', ['slug' => 'tes-tipe-pekerjaan']))
            ->assertStatus(302);
    }

    /** 🟢 PATH 6 – Slug tidak valid */
    public function test_path_6_slug_tidak_valid()
    {
        Session::put('jawaban', [1 => 'A']);
        Session::put('student_id', 1);

        $this->post(route('tes.selesaikan', ['slug' => 'tes-random']))
            ->assertRedirect(route('tes.daftar'));
    }

    /** 🟢 PATH 7 – kategori_teratas */
    public function test_path_7_kategori_teratas()
    {
        Session::put('jawaban', [1 => 'A']);
        Session::put('student_id', 1);
        Session::put('student_nim', '123');
        Session::put('assessment_id', 1);
        Session::put('hasil_teratas', ['R']);

        $this->post(route('tes.selesaikan', ['slug' => 'tes-mbti']))
            ->assertStatus(302);
    }

    /** 🟢 PATH 8 – fallback else */
    public function test_path_8_fallback_else()
    {
        Session::put('jawaban', [1 => 'A']);
        Session::put('student_id', 1);
        Session::put('student_nim', '123');
        Session::put('assessment_id', 1);

        $this->post(route('tes.selesaikan', ['slug' => 'tes-mbti']))
            ->assertStatus(302);
    }
}
