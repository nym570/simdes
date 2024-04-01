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
        Schema::create('master_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('master_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('master_hubungan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pendidikan');
        Schema::dropIfExists('master_pekerjaan');
        Schema::dropIfExists('master_hubungan');
    }
};
