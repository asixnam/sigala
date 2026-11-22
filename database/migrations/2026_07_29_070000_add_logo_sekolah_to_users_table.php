<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'logo_sekolah')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('logo_sekolah', 255)->nullable()->after('unit_kerja');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'logo_sekolah')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('logo_sekolah');
            });
        }
    }
};
