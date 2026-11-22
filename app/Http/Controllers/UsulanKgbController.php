<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsulanKgb;
use Illuminate\Support\Facades\Auth;

class UsulanKgbController extends Controller
{
    private function getAuthenticatedUser()
    {
        $defaultGuard = Auth::getDefaultDriver();
        if (Auth::guard($defaultGuard)->check()) {
            return Auth::guard($defaultGuard)->user();
        }
        foreach (['superadmin', 'admin_sekolah', 'gtk', 'web'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        return Auth::user();
    }

    /**
     * Show detail usulan page with embedded PDF reader.
     */
    public function show($id)
    {
        $usulan = UsulanKgb::with(['pegawai', 'skKgb'])->findOrFail($id);
        $user = $this->getAuthenticatedUser();

        // Otorisasi role:
        if ($user) {
            if (in_array($user->role, ['superadmin', 'admin_dinas', 'admin_tte'])) {
                // Authorized
            } elseif ($user->role === 'admin_sekolah') {
                if ($usulan->pegawai && $usulan->pegawai->unit_kerja !== $user->unit_kerja) {
                    abort(403, 'Anda tidak memiliki akses untuk melihat detail usulan sekolah lain.');
                }
            } elseif ($user->role === 'gtk') {
                if ($user->nip_pegawai && $usulan->nip !== $user->nip_pegawai) {
                    abort(403, 'Anda tidak memiliki akses untuk melihat usulan pegawai lain.');
                }
            }
        }

        return view('usulan.detail', compact('usulan'));
    }
}
