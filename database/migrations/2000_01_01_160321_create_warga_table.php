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
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('no_kk');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->string('agama');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('gol_darah');
            $table->string('kode_wilayah_ktp');
            $table->string('alamat_ktp');
            $table->string('no_telp');
            $table->boolean('ktp_desa');
            $table->string('status');
            $table->string('dokumen_kk')->nullable();
            $table->string('dokumen_ktp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
