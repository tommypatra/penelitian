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
        Schema::create('surat_penugasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_role_id');
            $table->foreign('user_role_id')->references('id')->on('user_roles')->restrictOnDelete();
            $table->foreignId('peneliti_id');
            $table->foreign('peneliti_id')->references('id')->on('penelitis')->restrictOnDelete();
            $table->date('tanggal_surat');
            $table->string('nomor_surat');

            //untuk validasi berkas
            $table->boolean('is_disetujui')->nullable();
            $table->string('catatan')->nullable();
            $table->foreignId('ketua_lppm_role_id')->nullable();
            $table->foreign('ketua_lppm_role_id')->references('id')->on('user_roles')->restrictOnDelete();
            $table->unique(['nomor_surat']);
            $table->unique(['peneliti_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_penugasans');
    }
};
