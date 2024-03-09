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
        Schema::table('dusun', function (Blueprint $table) {
            $table->unsignedBigInteger('pemimpin')->nullable();
            $table->foreign('pemimpin')->references('id')->on('users')->constrained();
        });
        Schema::table('rw', function (Blueprint $table) {
            $table->unsignedBigInteger('pemimpin')->nullable();
            $table->foreign('pemimpin')->references('id')->on('users')->constrained();
        });
        Schema::table('rt', function (Blueprint $table) {
            $table->unsignedBigInteger('pemimpin')->nullable();
            $table->foreign('pemimpin')->references('id')->on('users')->constrained();
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
