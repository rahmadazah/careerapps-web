<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hasil_mbti', function (Blueprint $table) {
            $table->string('test_id')->after('id'); // atau after student_id kalau kamu mau
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_mbti', function (Blueprint $table) {
            //
        });
    }
};
