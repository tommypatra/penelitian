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
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('keterangan', 150)->nullable();
            $table->boolean('is_pilihan')->default(1);
            $table->foreignId('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('unit_kerjas')->restrictOnDelete();

            $table->unique(['nama']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_kerjas');
    }
};
