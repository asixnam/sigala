<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SkKgb;
use Illuminate\Support\Facades\Auth;

class SkKgbController extends Controller
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

    private function checkAccess(SkKgb $sk)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return;

        $usulan = $sk->usulanKgb;
        if (!$usulan) abort(404, 'Usulan tidak ditemukan');

        if (in_array($user->role, ['superadmin', 'admin_dinas', 'admin_tte'])) {
            return;
        } elseif ($user->role === 'admin_sekolah') {
            if ($usulan->pegawai && $usulan->pegawai->unit_kerja !== $user->unit_kerja) {
                abort(403, 'Anda tidak memiliki akses untuk SK sekolah lain.');
            }
        } elseif ($user->role === 'gtk') {
            if ($user->nip_pegawai && $usulan->nip !== $user->nip_pegawai) {
                abort(403, 'Anda tidak memiliki akses untuk SK pegawai lain.');
            }
        }
    }

    /**
     * Public TTE Verification page (accessed when scanning QR Code).
     */
    public function verify($token)
    {
        $sk = SkKgb::with(['usulanKgb.pegawai'])
            ->where(function ($query) use ($token) {
                $query->where('qr_code_token', $token)
                      ->orWhere('nomor_sk', $token);
                if (is_numeric($token)) {
                    $query->orWhere('id', $token);
                }
            })
            ->firstOrFail();

        $usulan = $sk->usulanKgb;
        $pegawai = $usulan ? $usulan->pegawai : null;

        $penandatangan = [
            'nama' => $sk->penandatangan_nama ?: 'SUNARYO, S.Pd., M.Si.',
            'nip' => $sk->penandatangan_nip ?: '197003111994121002',
            'pangkat' => $sk->penandatangan_pangkat ?: 'Pembina Utama Muda',
            'jabatan' => $sk->penandatangan_jabatan ?: 'Kepala Dinas Pendidikan Kabupaten Blora',
        ];

        $formatSk = $sk->format_sk ?? ($pegawai && $pegawai->is_pppk ? 'pppk' : 'guru');

        return view('public.verify-tte', compact('sk', 'usulan', 'pegawai', 'penandatangan', 'formatSk'));
    }

    /**
     * Alias for preview SK KGB.
     */
    public function show($id)
    {
        return $this->preview($id);
    }

    /**
     * Preview SK KGB PDF in browser.
     */
    public function preview($id)
    {
        $sk = SkKgb::with(['usulanKgb.pegawai'])->findOrFail($id);
        $this->checkAccess($sk);

        $usulan = $sk->usulanKgb;
        $pegawai = $usulan ? $usulan->pegawai : null;
        $formatSk = $sk->format_sk ?? ($pegawai && $pegawai->is_pppk ? 'pppk' : 'guru');

        return view('pdf.sk-kgb', compact('sk', 'usulan', 'pegawai', 'formatSk'));
    }

    /**
     * Download SK KGB PDF.
     */
    public function download($id)
    {
        $sk = SkKgb::with(['usulanKgb.pegawai'])->findOrFail($id);
        $this->checkAccess($sk);

        $usulan = $sk->usulanKgb;
        $pegawai = $usulan ? $usulan->pegawai : null;
        $formatSk = $sk->format_sk ?? ($pegawai && $pegawai->is_pppk ? 'pppk' : 'guru');

        return response()->view('pdf.sk-kgb', compact('sk', 'usulan', 'pegawai', 'formatSk'))
            ->header('Content-Type', 'text/html');
    }
}
