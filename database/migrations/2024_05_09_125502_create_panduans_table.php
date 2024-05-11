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
        Schema::create('master_category_panduan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('panduan', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('kategori');
            $table->string('judul');
            $table->text('keterangan');
            $table->string('lampiran')->nullable();
            $table->boolean('is_show')->default(true);
            $table->timestamps();
            $table->foreign('kategori')->references('id')->on('master_category_panduan')->cascadeOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_category_panduan');
        Schema::dropIfExists('panduan');
    }
};
