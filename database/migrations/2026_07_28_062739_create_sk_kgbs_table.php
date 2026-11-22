<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sk_kgbs', function (Blueprint $table) {
            $table->id(); // BIGINT, Primary Key, Auto Increment
            $table->unsignedBigInteger('usulan_id'); // Foreign Key ke tabel usulan_kgb
            $table->string('nomor_sk', 100)->unique();
            $table->date('tanggal_sk');
            $table->string('file_pdf_path', 255);
            $table->string('file_tte_path', 255)->nullable();
            $table->enum('status_tte', ['pending', 'signed', 'failed'])->default('pending');
            $table->string('qr_code_token', 100)->unique();
            $table->timestamps(); // Mencakup created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('sk_kgbs');
    }
};
