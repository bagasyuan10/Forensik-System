<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pelaku', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Kasus
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');

            $table->string('nama');
            $table->string('foto')->nullable();

            // Biodata
            $table->text('biodata')->nullable(); 

            // Hubungan & Peran
            $table->string('hubungan_korban')->nullable();
            $table->string('peran')->nullable();

            // Pengakuan
            $table->text('pengakuan')->nullable();

            // --- PERBAIKAN DI SINI ---
            // Tambahkan 'Saksi' ke dalam daftar array
            $table->enum('status_hukum', ['Saksi', 'DPO', 'Tersangka', 'Terdakwa', 'Terpidana'])
                  ->default('Tersangka');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaku');
    }
};