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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('keterangan')->nullable();
            $table->enum('jenis', ['syarat', 'output']);
            $table->enum('tipe_file', ['gambar', 'pdf']);
            $table->boolean('is_wajib')->default(0);
            $table->foreignId('penelitian_id');
            $table->foreign('penelitian_id')->references('id')->on('penelitians')->restrictOnDelete();
            $table->unique(['nama', 'penelitian_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
