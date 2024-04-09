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
        Schema::create('master_category_info', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('info_publik', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->year('tahun');
            $table->string('judul');
            $table->string('penguasaan');
            $table->string('penanggung_jawab');
            $table->string('bentuk');
            $table->integer('retensi');
            $table->dateTime('waktu');
            $table->text('keterangan')->nullable();
            $table->string('lampiran')->nullable();
            $table->boolean('is_show')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_category_info');
        Schema::dropIfExists('info_publik');
    }
};
