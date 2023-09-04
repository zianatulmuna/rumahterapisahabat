<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->string('id_jadwal', 10)->unique();
            $table->string('id_pasien', 8);
            $table->string('id_terapis', 6)->nullable();
            $table->string('id_sub', 10);
            $table->time('waktu')->nullable();
            $table->date('tanggal');
            $table->enum('status', ['Terlaksana', 'Tertunda'])->default('Tertunda');
            $table->timestamps();

            $table->foreign('id_terapis')->references('id_terapis')->on('terapis')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_sub')->references('id_sub')->on('sub_rekam_medis')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
};
