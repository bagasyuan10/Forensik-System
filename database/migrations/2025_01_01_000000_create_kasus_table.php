<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kasus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nomor_kasus')->unique();
            $table->string('jenis'); // kriminial, cybercrime, kekerasan, dll
            $table->string('lokasi')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasus');
    }
};