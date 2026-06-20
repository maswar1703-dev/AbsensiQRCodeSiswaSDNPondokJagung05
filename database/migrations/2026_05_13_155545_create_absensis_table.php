<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('siswa_id');

            $table->date('tanggal');

            $table->time('jam');

            $table->enum('status', [
                'hadir',
                'izin',
                'sakit'
            ]);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};