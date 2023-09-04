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
        Schema::create('rekam_terapi', function (Blueprint $table) {
            $table->string('id_terapi', 8)->primary();
            $table->string('id_terapis', 6);
            $table->string('id_sub', 10);
            $table->string('id_admin', 6)->nullable();
            $table->time('waktu')->nullable();
            $table->date('tanggal');
            $table->string('keluhan', 100)->nullable();
            $table->string('deteksi', 100)->nullable();
            $table->string('tindakan', 100)->nullable();
            $table->string('saran', 100)->nullable();
            $table->string('pra_terapi', 100)->nullable();
            $table->string('post_terapi', 100)->nullable();
            $table->timestamps();

            $table->foreign('id_terapis')->references('id_terapis')->on('terapis')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_sub')->references('id_sub')->on('sub_rekam_medis')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_terapi');
    }
};
