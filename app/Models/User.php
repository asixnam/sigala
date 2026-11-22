<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'nip_pegawai',
        'unit_kerja',
        'logo_sekolah',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke Pegawai (Jika user terikat sebagai pegawai/GTK)
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip_pegawai', 'nip');
    }
}
