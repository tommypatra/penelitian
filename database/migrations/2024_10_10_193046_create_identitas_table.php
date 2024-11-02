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
        Schema::create('identitas', function (Blueprint $table) {
            $table->id();
            $table->string('gelar_depan', 150)->nullable();
            $table->string('gelar_belakang', 150)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('no_hp', 150)->nullable();
            $table->string('foto', 150)->default('images/user-avatar.png');
            $table->string('nip', 150)->nullable();
            $table->string('jabatan', 150)->nullable();
            $table->string('nidn', 150)->nullable();

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('unit_kerja_id')->nullable();
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerjas')->restrictOnDelete();
            $table->foreignId('pangkat_id')->nullable();
            $table->foreign('pangkat_id')->references('id')->on('pangkats')->restrictOnDelete();
            $table->unique(['user_id']);
            $table->unique(['nip']);
            $table->unique(['nidn']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas');
    }
};
