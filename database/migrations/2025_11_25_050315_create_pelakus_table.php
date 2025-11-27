<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelaku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');
            $table->string('nama');
            $table->integer('umur')->nullable();
            $table->string('status')->nullable(); // tersangka, saksi, buronan
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelakus');
    }
};
