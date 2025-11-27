<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('kasus', function (Blueprint $table) {

            // Tambah kolom jenis_kasus jika belum ada
            if (!Schema::hasColumn('kasus', 'jenis_kasus')) {
                $table->string('jenis_kasus')->nullable()->after('nomor_kasus');
            }

            // Tambah kolom status jika belum ada
            if (!Schema::hasColumn('kasus', 'status')) {
                $table->string('status')->default('Diproses')->after('deskripsi');
            }
        });
    }

    public function down()
    {
        Schema::table('kasus', function (Blueprint $table) {
            if (Schema::hasColumn('kasus', 'jenis_kasus')) {
                $table->dropColumn('jenis_kasus');
            }
            if (Schema::hasColumn('kasus', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};