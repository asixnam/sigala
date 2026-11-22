<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';

    protected $primaryKey = 'nip';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'jenis_pegawai',
        'jabatan',
        'tanggal_lahir',
        'gelar_depan',
        'gelar_belakang',
        'pangkat_gol',
        'masa_perjanjian_kerja',
        'perpanjangan_perjanjian_kerja',
        'sk_terakhir_pejabat',
        'sk_terakhir_no',
        'sk_terakhir_tgl',
        'dasar_peraturan',
        'gaji_pokok_lama',
        'mkg_tahun',
        'mkg_bulan',
        'tmt_kgb_terakhir',
        'tmt_kgb_yad',
        'unit_kerja',
        'foto_profil',
    ];

    /*
    |--------------------------------------------------------------------------
    | Helper Accessor
    |--------------------------------------------------------------------------
    */
    public function getIsTeknisiAttribute()
    {
        return strtolower($this->jenis_pegawai ?? '') === 'teknisi'
            || str_contains(strtolower($this->jabatan ?? ''), 'operator')
            || str_contains(strtolower($this->jabatan ?? ''), 'teknisi');
    }

    public function getIsGuruAttribute()
    {
        return strtolower($this->jenis_pegawai ?? '') === 'guru'
            || strtolower($this->jenis_pegawai ?? '') === 'pns';
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor Nama Lengkap
    |--------------------------------------------------------------------------
    */
    public function getNamaLengkapAttribute()
    {
        $gelarDepan = !empty($this->gelar_depan)
            ? trim($this->gelar_depan) . ' '
            : '';

        $gelarBelakang = !empty($this->gelar_belakang)
            ? ', ' . trim($this->gelar_belakang)
            : '';

        return $gelarDepan
            . ($this->nama ?? '')
            . $gelarBelakang;
    }

    // Relasi ke UsulanKgb
    public function usulanKgbs()
    {
        return $this->hasMany(UsulanKgb::class, 'nip', 'nip');
    }

    // Relasi ke User
    public function user()
    {
        return $this->hasOne(User::class, 'nip_pegawai', 'nip');
    }
}