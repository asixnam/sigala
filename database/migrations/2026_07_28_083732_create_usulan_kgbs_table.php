<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usulan_kgbs', function (Blueprint $table) {
            $table->id(); // BIGINT, Primary Key, Auto Increment
            $table->string('nip', 20); // Foreign Key ke tabel pegawais
            $table->string('nomor_usulan', 50)->unique();
            $table->integer('periode_bulan'); // 1-12
            $table->integer('periode_tahun');
            $table->decimal('gaji_pokok_baru', 12, 2);
            $table->integer('mkg_baru_tahun');
            $table->integer('mkg_baru_bulan');
            $table->date('tmt_berlaku');
            $table->enum('status', ['draft', 'verifikasi', 'disetujui', 'tte', 'selesai', 'ditolak'])->default('draft');
            $table->text('catatan_admin')->nullable();
            $table->timestamps(); // Mencakup created_at dan updated_at

            // Definisi Foreign Key merujuk ke NIP pada tabel pegawais
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usulan_kgbs');
    }
};
