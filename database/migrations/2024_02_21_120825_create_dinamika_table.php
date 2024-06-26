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
        Schema::create('dinamika', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->foreign('nik')->references('nik')->on('warga');
            $table->morphs('dinamika', 'dinamika');
            $table->timestamps();
            
        });
        Schema::create('kelahiran', function (Blueprint $table) {
            $table->id();
            $table->string('tempat');
            $table->dateTime('waktu');
            $table->float('berat', 8, 2);
            $table->float('panjang', 8, 2);
            $table->boolean('verifikasi')->default(false);
            $table->string('bukti');
            $table->string('keterangan')->nullable();
            $table->string('ibu_nik');
            $table->string('bapak_nik');
            $table->unsignedBigInteger('ruta_id')->nullable();
            $table->string('hubungan_ruta')->nullable();
            $table->foreign('ruta_id')->references('id')->on('ruta')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('kematian', function (Blueprint $table) {
            $table->id();
            $table->string('tempat');
            $table->dateTime('waktu');
            $table->unsignedTinyInteger('usia');
            $table->string('penyebab');
            $table->string('saksi');
            $table->boolean('verifikasi')->default(false);
            $table->string('bukti');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
        Schema::create('kedatangan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->boolean('verifikasi')->default(false);
            $table->string('bukti');
            $table->string('keterangan')->nullable();
            $table->string('kepala');
            $table->boolean('is_new');
            $table->string('alamat_domisili')->nullable();
            $table->timestamps();
        });
        Schema::create('kepindahan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->string('kode_wilayah_pindah');
            $table->string('alamat_pindah');
            $table->string('jenis');
            $table->string('penyebab');
            $table->boolean('verifikasi')->default(false);
            $table->string('bukti');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinamika');
        Schema::dropIfExists('kelahiran');
        Schema::dropIfExists('kematian');
        Schema::dropIfExists('kedatangan');
        Schema::dropIfExists('kepindahan');
    }
};
