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
        Schema::create('pengajuan_info_publik', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique();
            $table->unsignedInteger('no_urut');
            $table->string('nama');
            $table->string('nik_pengaju');
            $table->string('email');
            $table->string('no_telp');
            $table->string('alamat');
            $table->string('pekerjaan');
            $table->text('tujuan');
            $table->text('rincian');
            $table->string('cara_perolehan');
            $table->string('media_perolehan');
            $table->string('lampiran');
            $table->string('bukti');
            $table->string('status')->default('diajukan');
            $table->boolean('is_verified')->nullable();
            $table->unsignedInteger('biaya')->nullable();
            $table->unsignedInteger('cara_bayar')->nullable();
            $table->string('penolakan')->nullable();
            $table->string('kuasa')->nullable();
            $table->text('keterangan')->nullable();
            $table->datetime('waktu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_info_publik');
    }
};
