<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
    {
        Schema::create('bukti', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Kasus
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');

            $table->string('kategori'); // Senjata, Digital, Dokumen, dll
            $table->string('nama_bukti');
            
            // Info File Upload
            $table->string('file_path')->nullable(); // Lokasi penyimpanan file
            $table->string('file_type')->nullable(); // Mime Type (image/jpeg, application/pdf)
            $table->bigInteger('file_size')->nullable(); // Ukuran file dalam bytes

            // Detail Tambahan
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