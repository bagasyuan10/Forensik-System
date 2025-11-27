<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('barang_bukti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');
            $table->foreignId('pelaku_id')->nullable()->constrained('pelaku')->onDelete('cascade');

            $table->string('nama_bukti');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_bukti');
    }
};