<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('pegawais', 'foto_profil')) {
            Schema::table('pegawais', function (Blueprint $table) {
                $table->string('foto_profil', 255)->nullable()->after('unit_kerja');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('pegawais', 'foto_profil')) {
            Schema::table('pegawais', function (Blueprint $table) {
                $table->dropColumn('foto_profil');
            });
        }
    }
};
