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
        Schema::create('rw', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('dusun_id');
            $table->foreign('dusun_id')->references('id')->on('dusun')->constrained();
            $table->string('nama_ketua_rw');
            $table->unsignedBigInteger('ketua_rw');
            $table->foreign('ketua_rw')->references('id')->on('roles')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rw');
    }
};
