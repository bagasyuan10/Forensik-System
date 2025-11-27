<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bukti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');

            $table->string('kategori'); 
            $table->string('nama_bukti');
            $table->string('foto')->nullable(); // file bukti / foto

            $table->text('deskripsi')->nullable();
            $table->string('lokasi_ditemukan')->nullable();
            $table->dateTime('waktu_ditemukan')->nullable();
            $table->string('petugas_menemukan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bukti');
    }
};