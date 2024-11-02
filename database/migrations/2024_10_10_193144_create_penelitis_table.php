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
        Schema::create('penelitis', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->foreignId('user_role_id');
            $table->foreign('user_role_id')->references('id')->on('user_roles')->restrictOnDelete();
            $table->foreignId('penelitian_id');
            $table->foreign('penelitian_id')->references('id')->on('penelitians')->restrictOnDelete();
            $table->boolean('is_selesai')->nullable();

            //untuk validasi akhir peneliti
            $table->boolean('is_valid')->nullable();
            $table->string('catatan', 150)->nullable();
            $table->foreignId('admin_role_id')->nullable();
            $table->foreign('admin_role_id')->references('id')->on('user_roles')->restrictOnDelete();

            $table->unique(['user_role_id', 'penelitian_id']);

            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitis');
    }
};
