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
        Schema::create('dusun', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('kepala_dusun');
            $table->foreign('kepala_dusun')->references('id')->on('roles')->constrained();
            $table->string('kepala_dusun_nik');
            $table->foreign('kepala_dusun_nik')->references('nik')->on('warga')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dusun');
    }
};
