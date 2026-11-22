<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('nip', 20)->primary(); // NIP sebagai Primary Key
            $table->string('nama', 150);
            $table->date('tanggal_lahir')->nullable();
            $table->string('gelar_depan', 20)->nullable();
            $table->string('gelar_belakang', 20)->nullable();
            $table->string('pangkat_gol', 10);
            $table->decimal('gaji_pokok_lama', 12, 2);
            $table->integer('mkg_tahun');
            $table->integer('mkg_bulan');
            $table->date('tmt_kgb_terakhir');
            $table->date('tmt_kgb_yad'); // TMT KGB Yang Akan Datang (Jatuh Tempo)
            $table->string('unit_kerja', 150);
            $table->timestamps(); // Mencakup created_at dan updated_at (sinkronisasi SIMPEG)
        });
    }

    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};
