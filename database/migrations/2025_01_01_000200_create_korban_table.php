<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('korban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');
            
            // --- IDENTITAS ---
            $table->string('nik')->nullable(); // BARU
            $table->string('nama');
            $table->string('tempat_lahir')->nullable(); // BARU
            $table->date('tanggal_lahir')->nullable();  // BARU (Ganti Usia jadi Tanggal Lahir)
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_telp')->nullable();      // BARU (Pengganti Kontak)
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();

            // --- KONDISI ---
            $table->string('status_korban')->nullable(); // BARU (Luka Ringan, Meninggal, dll)
            $table->text('keterangan_luka')->nullable(); // BARU (Pengganti Luka)
            $table->text('versi_kejadian')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('korban');
    }
};