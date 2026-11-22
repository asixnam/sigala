<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsulanKgbController;
use App\Http\Controllers\SkKgbController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Sekolah\SekolahDashboardController;
use App\Http\Controllers\Gtk\GtkDashboardController;


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// Landing page / Login
Route::get('/', [AuthController::class, 'index'])
    ->name('login');

// Proses Login
Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login.authenticate');

// Login Google OAuth 2.0 (Langsung Masuk Akun Gmail)
Route::get('/auth/google', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'redirectToGoogle'])
    ->name('auth.google');

Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');

Route::post('/auth/google/direct', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'directLoginByEmail'])
    ->name('auth.google.direct');

// Lupa Password & OTP Gmail
Route::post('/forgot-password/send-otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendOtp'])
    ->name('password.otp.send');

Route::post('/forgot-password/verify-reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPasswordWithOtp'])
    ->name('password.otp.verify');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| VERIFIKASI TTE PUBLIK (SCAN QR CODE)
|--------------------------------------------------------------------------
|
| Dapat diakses secara publik tanpa login ketika memindai QR Code resmi SK KGB
|
*/
Route::get('/verifikasi-tte/{token}', [SkKgbController::class, 'verify'])
    ->name('sk.verify');

Route::get('/validasi-tte/{token}', [SkKgbController::class, 'verify'])
    ->name('tte.verify');


/*
|--------------------------------------------------------------------------
| SHARED / UMUM
|--------------------------------------------------------------------------
|
| Route yang dapat digunakan oleh beberapa role.
|
*/

// Detail Usulan KGB
Route::middleware(['role:superadmin,admin_dinas,admin_tte,admin_sekolah,gtk'])->group(function () {

    Route::get('/usulan/{id}', [UsulanKgbController::class, 'show'])
        ->name('usulan.show');

});


/*
|--------------------------------------------------------------------------
| ADMIN / DINAS
|--------------------------------------------------------------------------
*/

Route::middleware(['role:superadmin,admin_dinas,admin_tte'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | GTK / PEGAWAI
    |--------------------------------------------------------------------------
    */

    // Daftar GTK
    Route::get('/admin/gtk', [AdminDashboardController::class, 'gtkIndex'])
        ->name('admin.gtk');

    // Tambah GTK
    Route::post('/admin/gtk', [AdminDashboardController::class, 'gtkStore'])
        ->name('admin.gtk.store');

    // Update GTK
    Route::put('/admin/gtk/{nip}', [AdminDashboardController::class, 'gtkUpdate'])
        ->name('admin.gtk.update');

    // Hapus GTK
    Route::delete('/admin/gtk/{nip}', [AdminDashboardController::class, 'gtkDestroy'])
        ->name('admin.gtk.destroy');


    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */

    // Halaman Settings
    Route::get('/admin/settings', [SettingsController::class, 'index'])
        ->name('admin.settings');

    // Simpan Settings
    Route::post('/admin/settings', [SettingsController::class, 'update'])
        ->name('admin.settings.update');


    /*
    |--------------------------------------------------------------------------
    | USULAN KGB
    |--------------------------------------------------------------------------
    */

    // Daftar Usulan
    Route::get('/admin/usulan', [AdminDashboardController::class, 'usulanIndex'])
        ->name('admin.usulan');

    // Tambah Usulan
    Route::post('/admin/usulan', [AdminDashboardController::class, 'usulanStore'])
        ->name('admin.usulan.store');

    // Update Usulan
    Route::put('/admin/usulan/{id}', [AdminDashboardController::class, 'usulanUpdate'])
        ->name('admin.usulan.update');

    // Hapus Usulan
    Route::delete('/admin/usulan/{id}', [AdminDashboardController::class, 'usulanDestroy'])
        ->name('admin.usulan.destroy');

    // Update Status Usulan
    Route::match(['post', 'put'], '/admin/usulan/{id}/status', [AdminDashboardController::class, 'usulanUpdateStatus'])
        ->name('admin.usulan.updateStatus');

    // Generate SK
    Route::post('/admin/usulan/{id}/generate-sk', [AdminDashboardController::class, 'usulanGenerateSk'])
        ->name('admin.usulan.generateSk');


    /*
    |--------------------------------------------------------------------------
    | SEKOLAH - ADMIN DINAS
    |--------------------------------------------------------------------------
    */

    // Daftar Sekolah
    Route::get('/admin/sekolah', [AdminDashboardController::class, 'sekolahIndex'])
        ->name('admin.sekolah');

    // Tambah Sekolah
    Route::post('/admin/sekolah', [AdminDashboardController::class, 'sekolahStore'])
        ->name('admin.sekolah.store');

    // Update Sekolah
    Route::put('/admin/sekolah/{id}', [AdminDashboardController::class, 'sekolahUpdate'])
        ->name('admin.sekolah.update');

    // Hapus Sekolah
    Route::delete('/admin/sekolah/{id}', [AdminDashboardController::class, 'sekolahDestroy'])
        ->name('admin.sekolah.destroy');

});


/*
|--------------------------------------------------------------------------
| SEKOLAH
|--------------------------------------------------------------------------
*/

Route::middleware(['role:admin_sekolah'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Sekolah
    |--------------------------------------------------------------------------
    */

    Route::get('/sekolah/dashboard', [SekolahDashboardController::class, 'index'])
        ->name('sekolah.dashboard');

        /*
|--------------------------------------------------------------------------
| DATA GTK / PEGAWAI SEKOLAH
|--------------------------------------------------------------------------
*/

Route::get('/sekolah/gtk', [SekolahDashboardController::class, 'gtkIndex'])
    ->name('sekolah.gtk');

Route::post('/sekolah/gtk', [SekolahDashboardController::class, 'gtkStore'])
    ->name('sekolah.gtk.store');

Route::put('/sekolah/gtk/{nip}', [SekolahDashboardController::class, 'gtkUpdate'])
    ->name('sekolah.gtk.update');

Route::delete('/sekolah/gtk/{nip}', [SekolahDashboardController::class, 'gtkDestroy'])
    ->name('sekolah.gtk.destroy');


    /*
    |--------------------------------------------------------------------------
    | Usulan KGB Sekolah
    |--------------------------------------------------------------------------
    */

    // Daftar Usulan
    Route::get('/sekolah/usulan', [SekolahDashboardController::class, 'usulanIndex'])
        ->name('sekolah.usulan');

    // Tambah Usulan
    Route::post('/sekolah/usulan', [SekolahDashboardController::class, 'usulanStore'])
        ->name('sekolah.usulan.store');


    Route::get('/sekolah/profil', [SekolahDashboardController::class, 'profil'])
        ->name('sekolah.profil');

    Route::post('/sekolah/profil', [SekolahDashboardController::class, 'profilUpdate'])
        ->name('sekolah.profil.update');

});


/*
|--------------------------------------------------------------------------
| GTK
|--------------------------------------------------------------------------
*/

Route::middleware(['role:gtk'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard GTK
    |--------------------------------------------------------------------------
    */

    Route::get('/gtk/dashboard', [GtkDashboardController::class, 'index'])
        ->name('gtk.dashboard');

    Route::get('/gtk/profil', [GtkDashboardController::class, 'profil'])
    ->name('gtk.profil');

    Route::post('/gtk/profil', [GtkDashboardController::class, 'profilUpdate'])
    ->name('gtk.profil.update');


    /*
    |--------------------------------------------------------------------------
    | Usulan KGB GTK
    |--------------------------------------------------------------------------
    */

    // Daftar Usulan
    Route::get('/gtk/usulan', [GtkDashboardController::class, 'usulanIndex'])
        ->name('gtk.usulan');

    // Tambah Usulan
    Route::post('/gtk/usulan', [GtkDashboardController::class, 'usulanStore'])
        ->name('gtk.usulan.store');

    Route::put('/gtk/usulan/{id}', [GtkDashboardController::class, 'usulanUpdate'])
        ->name('gtk.usulan.update');

});


/*
|--------------------------------------------------------------------------
| SK KGB
|--------------------------------------------------------------------------
*/

Route::middleware(['role:superadmin,admin_dinas,admin_tte,admin_sekolah,gtk'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Detail / Pratinjau SK
    |--------------------------------------------------------------------------
    */

    Route::get('/sk-kgb/{id}', [SkKgbController::class, 'preview'])
        ->name('sk.preview');

    Route::get('/sk-kgb/{id}/preview', [SkKgbController::class, 'preview'])
        ->name('sk-kgb.show');


    /*
    |--------------------------------------------------------------------------
    | Download / Cetak SK
    |--------------------------------------------------------------------------
    */

    Route::get('/sk-kgb/{id}/download', [SkKgbController::class, 'download'])
        ->name('sk.download');

    Route::get('/sk-kgb/{id}/unduh', [SkKgbController::class, 'download'])
        ->name('sk-kgb.download');

        

});