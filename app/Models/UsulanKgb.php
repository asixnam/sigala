<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanKgb extends Model
{
    use HasFactory;

    protected $table = 'usulan_kgbs';

    protected $fillable = [
        'nip',
        'nomor_usulan',
        'periode_bulan',
        'periode_tahun',
        'gaji_pokok_baru',
        'mkg_baru_tahun',
        'mkg_baru_bulan',
        'tmt_berlaku',
        'status',
        'catatan_admin',
        'berkas_pdf',
    ];

    protected $casts = [
        'berkas_pdf' => 'array',
    ];

    // Relasi ke Pegawai (Usulan milik seorang pegawai berdasarkan NIP)
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    // Relasi ke SkKgb (Satu usulan menghasilkan satu SK KGB)
    public function skKgb()
    {
        return $this->hasOne(SkKgb::class, 'usulan_id', 'id');
    }
}
