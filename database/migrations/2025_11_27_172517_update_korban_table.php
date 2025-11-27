<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('korban', function (Blueprint $table) {
            // rename umur → usia
            if (Schema::hasColumn('korban', 'umur')) {
                $table->renameColumn('umur', 'usia');
            }

            // tambah kolom baru
            $table->string('foto')->nullable()->after('nama');
            $table->string('kontak')->nullable()->after('foto');
            $table->text('luka')->nullable()->after('jenis_kelamin');
            $table->text('versi_kejadian')->nullable()->after('keterangan');
        });
    }

    public function down()
    {
        Schema::table('korban', function (Blueprint $table) {

            // rollback rename usia → umur (jika perlu)
            if (Schema::hasColumn('korban', 'usia')) {
                $table->renameColumn('usia', 'umur');
            }

            $table->dropColumn(['foto', 'kontak', 'luka', 'versi_kejadian']);
        });
    }
};
