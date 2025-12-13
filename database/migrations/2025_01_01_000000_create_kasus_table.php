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
            
            // Kolom penting untuk dashboard & filter
            $table->string('jenis_kasus'); // Ganti 'jenis' jadi 'jenis_kasus' biar konsisten
            $table->string('status')->default('dibuat'); // dibuat, penyidikan, selesai, diarsipkan
            
            $table->string('lokasi')->nullable();
            
            // Kolom tanggal kejadian (PENTING untuk grafik dashboard)
            $table->date('tanggal_kejadian')->nullable(); 
            
            $table->text('deskripsi')->nullable();
            $table->string('penyidik')->nullable(); // Tambahan untuk form create
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasus');
    }
};