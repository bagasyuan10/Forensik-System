<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            
            // PENTING: Tambahkan ->nullable() di sini
            $table->foreignId('kasus_id')->nullable()->constrained('kasus')->onDelete('cascade');
            
            $table->string('judul_laporan');
            $table->text('isi_laporan')->nullable();
            $table->date('tanggal_laporan')->nullable();
            $table->string('penyusun')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};