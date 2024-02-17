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
        Schema::create('ruta', function (Blueprint $table) {
            $table->id();
            $table->string('alamat_domisili');
            $table->tinyInteger('jumlah_art');
            $table->unsignedBigInteger('rt_id');
            $table->foreign('rt_id')->references('id')->on('rt')->constrained();
            $table->timestamps();
        });
        Schema::create('anggota_ruta', function (Blueprint $table) {
            $table->id();
            $table->string('anggota_nik');
            $table->foreign('anggota_nik')->references('nik')->on('warga')->constrained();
            $table->unsignedBigInteger('ruta_id');
            $table->foreign('ruta_id')->references('id')->on('ruta')->constrained();
            $table->string('hubungan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruta');
        Schema::dropIfExists('anggota_ruta');
    }
};
