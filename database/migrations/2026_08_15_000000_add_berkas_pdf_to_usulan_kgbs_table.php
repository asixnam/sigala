<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usulan_kgbs', function (Blueprint $table) {
            if (!Schema::hasColumn('usulan_kgbs', 'berkas_pdf')) {
                $table->json('berkas_pdf')->nullable()->after('catatan_admin');
            }
        });
    }

    public function down()
    {
        Schema::table('usulan_kgbs', function (Blueprint $table) {
            if (Schema::hasColumn('usulan_kgbs', 'berkas_pdf')) {
                $table->dropColumn('berkas_pdf');
            }
        });
    }
};
