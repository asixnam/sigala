<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // PegawaiSeeder::class,   // Dinonaktifkan — data pegawai diinput manual
            // UsulanKgbSeeder::class, // Dinonaktifkan — data usulan diinput manual
        ]);
    }
}
