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
        Schema::create('pemerintahan', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->text('tugas')->nullable();
            $table->text('wewenang')->nullable();
            $table->timestamps();
            $table->foreign('nik')->references('nik')->on('warga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemerintahan');
    }
};
