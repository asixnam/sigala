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
        if (Schema::hasTable('pegawais')) {
            Schema::table('pegawais', function (Blueprint $table) {
                if (!Schema::hasColumn('pegawais', 'jenis_pegawai')) {
                    $table->string('jenis_pegawai', 20)->default('PNS')->after('nama');
                }
                if (!Schema::hasColumn('pegawais', 'jabatan')) {
                    $table->string('jabatan', 150)->nullable()->after('pangkat_gol');
                }
                if (!Schema::hasColumn('pegawais', 'masa_perjanjian_kerja')) {
                    $table->string('masa_perjanjian_kerja', 100)->nullable()->after('jabatan');
                }
                if (!Schema::hasColumn('pegawais', 'perpanjangan_perjanjian_kerja')) {
                    $table->string('perpanjangan_perjanjian_kerja', 100)->nullable()->after('masa_perjanjian_kerja');
                }
                if (!Schema::hasColumn('pegawais', 'sk_terakhir_pejabat')) {
                    $table->string('sk_terakhir_pejabat', 150)->nullable();
                }
                if (!Schema::hasColumn('pegawais', 'sk_terakhir_no')) {
                    $table->string('sk_terakhir_no', 100)->nullable();
                }
                if (!Schema::hasColumn('pegawais', 'sk_terakhir_tgl')) {
                    $table->date('sk_terakhir_tgl')->nullable();
                }
                if (!Schema::hasColumn('pegawais', 'dasar_peraturan')) {
                    $table->string('dasar_peraturan', 150)->nullable();
                }
            });
        }

        if (Schema::hasTable('sk_kgbs')) {
            Schema::table('sk_kgbs', function (Blueprint $table) {
                if (!Schema::hasColumn('sk_kgbs', 'format_sk')) {
                    $table->string('format_sk', 20)->default('guru')->after('nomor_sk');
                }
                if (!Schema::hasColumn('sk_kgbs', 'penandatangan_nama')) {
                    $table->string('penandatangan_nama', 150)->nullable();
                }
                if (!Schema::hasColumn('sk_kgbs', 'penandatangan_nip')) {
                    $table->string('penandatangan_nip', 30)->nullable();
                }
                if (!Schema::hasColumn('sk_kgbs', 'penandatangan_pangkat')) {
                    $table->string('penandatangan_pangkat', 100)->nullable();
                }
                if (!Schema::hasColumn('sk_kgbs', 'penandatangan_jabatan')) {
                    $table->string('penandatangan_jabatan', 150)->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe rollback if needed
    }
};

