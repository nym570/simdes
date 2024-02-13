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
            
            $table->string('nik')->primary();
            $table->string('no_kk');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->enum('agama',['islam','kristen','katolik','hindu','budha','konghucu']);
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('gol_darah');
            $table->string('kode_wilayah_ktp');
            $table->string('alamat_ktp');
            $table->string('no_telp');
            $table->boolean('ktp_desa');
            $table->enum('status',['warga','tinggal ditempat lain karena bekerja/bersekolah','meninggal','pindah']);
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
