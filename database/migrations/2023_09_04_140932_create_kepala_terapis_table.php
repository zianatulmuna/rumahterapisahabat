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
        Schema::create('kepala_terapis', function (Blueprint $table) {
            $table->string('id_kepala', 6)->primary();
            $table->string('username', 30)->unique();
            $table->string('nama', 50);
            $table->string('no_telp', 14);
            $table->string('alamat', 100);
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-Laki']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->string('foto', 50)->nullable();
            $table->string('password', 60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepala_terapis');
    }
};
