<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('hasil_mbti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Bisa dari session
            $table->string('tipe'); // Contoh: ENFP
            $table->json('jumlah'); // {"E":5,"I":2,...}
            $table->json('persentase'); // {"E":71,"I":29,...}
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_mbti');
    }
};
