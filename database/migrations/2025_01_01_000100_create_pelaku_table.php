<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pelaku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');

            $table->string('nama');
            $table->string('foto')->nullable();

            // biodata lengkap
            $table->integer('umur')->nullable();
            $table->string('alamat')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('riwayat_kriminal')->nullable();
            $table->text('ciri_fisik')->nullable();

            // hubungan & peran
            $table->string('hubungan_korban')->nullable();
            $table->string('peran')->nullable();

            // kronologi/pengakuan
            $table->text('pengakuan')->nullable();

            // status hukum
            $table->enum('status_hukum', ['DPO', 'Tersangka', 'Terdakwa', 'Terpidana'])
                  ->default('Tersangka');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaku');
    }
};
