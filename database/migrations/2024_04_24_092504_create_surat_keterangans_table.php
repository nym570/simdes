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

        Schema::create('surat_keterangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik');
            $table->foreign('nik')->references('nik')->on('warga');
            $table->string('jenis');
            $table->string('penanggung_jawab');
            $table->string('keperluan');
            $table->enum('tingkat',['rt','rw','desa']);
            $table->string('no_surat')->unique()->nullable();
            $table->string('status');
            $table->UnsignedTinyinteger('verifikasi');
            $table->string('tracking');
            $table->string('file')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan');
    }
};
