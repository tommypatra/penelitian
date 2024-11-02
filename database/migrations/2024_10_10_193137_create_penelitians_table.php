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
        Schema::create('penelitians', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->year('tahun');
            $table->date('daftar_mulai')->nullable();
            $table->date('daftar_selesai')->nullable();
            $table->boolean('daftar_terbuka')->default(0);

            $table->foreignId('jenis_penelitian_id');
            $table->foreign('jenis_penelitian_id')->references('id')->on('jenis_penelitians')->restrictOnDelete();
            $table->foreignId('user_role_id');
            $table->foreign('user_role_id')->references('id')->on('user_roles')->restrictOnDelete();

            $table->unique(['nama', 'tahun']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitians');
    }
};
