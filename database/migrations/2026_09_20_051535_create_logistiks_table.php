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
        Schema::create('logistiks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('tipe', ['obat', 'makanan', 'pakaian', 'lainnya']);
            $table->integer('jumlah');
            $table->foreignId('posko_id')->constrained('poskos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logistiks');
    }
};
