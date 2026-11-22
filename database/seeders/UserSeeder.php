<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================================
        // AKUN DEVELOPER / OWNER — Bisa login NIP/Password & Google
        // Gmail terdaftar: creativeasix@gmail.com
        // ============================================================
        User::updateOrCreate(
            ['username' => 'asixnam'],
            [
                'email'      => 'creativeasix@gmail.com',
                'password'   => Hash::make('asixnam200304'),
                'role'       => 'superadmin',
                'unit_kerja' => 'Developer SIGALA',
                // google_id & avatar akan otomatis diisi saat pertama kali login via Google
            ]
        );


    }
}
