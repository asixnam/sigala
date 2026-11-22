<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkKgb extends Model
{
    use HasFactory;

    protected $table = 'sk_kgbs';

    protected $fillable = [
        'usulan_id',
        'nomor_sk',
        'format_sk',
        'tanggal_sk',
        'penandatangan_nama',
        'penandatangan_nip',
        'penandatangan_pangkat',
        'penandatangan_jabatan',
        'file_pdf_path',
        'file_tte_path',
        'status_tte',
        'qr_code_token',
    ];

    // Relasi ke UsulanKgb
    public function usulanKgb()
    {
        return $this->belongsTo(UsulanKgb::class, 'usulan_id', 'id');
    }
}
