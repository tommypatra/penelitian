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
        Schema::create('dokumen_penelitis', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->foreignId('dokumen_id');
            $table->foreign('dokumen_id')->references('id')->on('dokumens')->restrictOnDelete();
            $table->foreignId('peneliti_id');
            $table->foreign('peneliti_id')->references('id')->on('penelitis')->restrictOnDelete();
            $table->string('keterangan')->nullable();

            //untuk validasi berkas
            $table->boolean('is_valid')->nullable();
            $table->string('catatan')->nullable();
            $table->foreignId('admin_role_id')->nullable();
            $table->foreign('admin_role_id')->references('id')->on('user_roles')->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_penelitis');
    }
};
