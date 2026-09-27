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
        Schema::create('korbans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade');
            $table->foreignId('posko_id')->constrained('poskos')->onDelete('cascade');
            $table->string('name');
            $table->string('usia');
            $table->enum('kondisi', ['sehat', 'luka', 'kritis']);
            $table->string('nik')->nullable();
            $table->enum('kelompok_rentan', ['hamil', 'bayi', 'lansia', 'disabilitas'])->nullable();
            $table->string('kebutuhan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korbans');
    }
};
