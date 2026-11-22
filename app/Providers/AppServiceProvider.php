<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\UsulanKgb;
use App\Models\SkKgb;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Safe auto-migration for newly added columns if not yet migrated
        try {
            if ($this->app->runningInConsole()) {
                if (Schema::hasTable('pegawais')) {
                    Schema::table('pegawais', function (Blueprint $table) {
                        if (!Schema::hasColumn('pegawais', 'jenis_pegawai')) {
                            $table->string('jenis_pegawai', 20)->default('PNS')->nullable();
                        }
                        if (!Schema::hasColumn('pegawais', 'jabatan')) {
                            $table->string('jabatan', 150)->nullable();
                        }
                        if (!Schema::hasColumn('pegawais', 'masa_perjanjian_kerja')) {
                            $table->string('masa_perjanjian_kerja', 100)->nullable();
                        }
                        if (!Schema::hasColumn('pegawais', 'perpanjangan_perjanjian_kerja')) {
                            $table->string('perpanjangan_perjanjian_kerja', 100)->nullable();
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
                            $table->string('format_sk', 20)->default('guru')->nullable();
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

                if (Schema::hasTable('users')) {
                    Schema::table('users', function (Blueprint $table) {
                        if (!Schema::hasColumn('users', 'google_id')) {
                            $table->string('google_id', 100)->nullable();
                        }
                        if (!Schema::hasColumn('users', 'avatar')) {
                            $table->string('avatar', 255)->nullable();
                        }
                        if (!Schema::hasColumn('users', 'reset_otp')) {
                            $table->string('reset_otp', 10)->nullable();
                        }
                        if (!Schema::hasColumn('users', 'reset_otp_expires_at')) {
                            $table->timestamp('reset_otp_expires_at')->nullable();
                        }
                    });
                }
            }

            // Pastikan Akun Super Admin Kepala Dinas SUNARYO tersedia (hanya create jika belum ada)
            if (Schema::hasTable('users')) {
                if (!User::where('username', 'kadis_sunaryo')->exists()) {
                    User::create([
                        'username' => 'kadis_sunaryo',
                        'email' => 'kadis@dindik.blorakab.go.id',
                        'password' => Hash::make('kadis123'),
                        'role' => 'superadmin',
                        'nip_pegawai' => '197003111994121002',
                        'unit_kerja' => 'Dinas Pendidikan Kab. Blora',
                    ]);
                }

                if (!User::where('username', '197003111994121002')->exists()) {
                    User::create([
                        'username' => '197003111994121002',
                        'email' => 'sunaryo@blorakab.go.id',
                        'password' => Hash::make('19700311'),
                        'role' => 'superadmin',
                        'nip_pegawai' => '197003111994121002',
                        'unit_kerja' => 'Dinas Pendidikan Kab. Blora',
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Abaikan agar proses booting tetap berjalan lancar
        }
    }
}
