<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelaku_bukti', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel Pelaku
            $table->foreignId('pelaku_id')->constrained('pelaku')->onDelete('cascade');
            
            // Foreign Key ke tabel Bukti
            $table->foreignId('bukti_id')->constrained('bukti')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaku_bukti');
    }
};