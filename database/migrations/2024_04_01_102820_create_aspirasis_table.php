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
        Schema::create('master_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->UnsignedBigInteger('kategori');
            $table->string('judul');
            $table->enum('tingkat',['desa','dusun','rw','rt']);
            $table->text('isi');
            $table->boolean('is_open')->default(true);
            $table->string('lampiran')->nullable();
            $table->timestamps();
            $table->foreign('kategori')->references('id')->on('master_category')->cascadeOnDelete();
        });
        Schema::create('balas_aspirasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('aspirasi_id')->nullable();
            $table->foreign('aspirasi_id')->references('id')->on('aspirasi')->constrained()->onDelete('cascade');
            $table->text('isi');
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_category');
        Schema::dropIfExists('balas_aspirasi');
        Schema::dropIfExists('aspirasi');
       
    }
};
