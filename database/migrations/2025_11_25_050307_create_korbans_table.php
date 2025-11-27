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
        Schema::create('korban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade');
            $table->string('nama');
            $table->integer('umur');
            $table->string('jenis_kelamin');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korbans');
    }
};
