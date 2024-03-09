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
            $table->timestamps();
        });
        Schema::create('rw', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('dusun_id');
            $table->foreign('dusun_id')->references('id')->on('dusun')->constrained();
            $table->timestamps();
        });
        Schema::create('rt', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('rw_id');
            $table->foreign('rw_id')->references('id')->on('rw')->constrained();

            $table->timestamps();
            $table->unique(['rw_id', 'name']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dusun');
        Schema::dropIfExists('rw');
        Schema::dropIfExists('rt');
    }
};
