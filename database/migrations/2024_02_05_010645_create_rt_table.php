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
        Schema::create('rt', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('rw_id');
            $table->foreign('rw_id')->references('id')->on('rw')->constrained();
            $table->unsignedBigInteger('ketua_rt');
            $table->foreign('ketua_rt')->references('id')->on('roles')->constrained();
            $table->string('ketua_rt_nik');
            $table->foreign('ketua_rt_nik')->references('nik')->on('warga')->constrained();
            $table->timestamps();
            $table->unique(['rw_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rt');
    }
};
