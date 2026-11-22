<?php

namespace App\Http\Controllers\Gtk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\UsulanKgb;
use App\Models\SkKgb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GtkDashboardController extends Controller
{
    private function getPegawai()
    {
        $user = Auth::user();

        if (!$user || empty($user->nip_pegawai)) {
            return null;
        }

        return Pegawai::where('nip', $user->nip_pegawai)->first();
    }

    public function index()
    {
        $pegawai = $this->getPegawai();

        if (!$pegawai) {
            return redirect()->route('login')->with('error', 'Data pegawai tidak ditemukan.');
        }

        $latestUsulan = UsulanKgb::where('nip', $pegawai->nip)->with('skKgb')->latest()->first();
        $usulanHistory = UsulanKgb::where('nip', $pegawai->nip)->with('skKgb')->latest()->get();
        $signedSks = SkKgb::whereHas('usulanKgb', function ($q) use ($pegawai) {
            $q->where('nip', $pegawai->nip);
        })->where('status_tte', 'signed')->latest()->get();

        // Compute KGB Analytics
        $estimatedNewSalary = $latestUsulan ? (float) $latestUsulan->gaji_pokok_baru : ($pegawai->gaji_pokok_lama ? round($pegawai->gaji_pokok_lama * 1.08) : 0);
        $salaryIncrement = max(0, $estimatedNewSalary - (float) $pegawai->gaji_pokok_lama);
        $yearlyIncrement = $salaryIncrement > 0 ? round($salaryIncrement / 2) : 0;

        $daysUntilKgb = 0;
        $monthsUntilKgb = 0;
        $progressPercent = 100;

        if ($pegawai->tmt_kgb_yad) {
            $yadDate = \Carbon\Carbon::parse($pegawai->tmt_kgb_yad);
            $now = \Carbon\Carbon::now();

            if ($yadDate->isFuture()) {
                $daysUntilKgb = (int) $now->diffInDays($yadDate);
                $monthsUntilKgb = (int) round($daysUntilKgb / 30.44);

                $totalDays = 730; // 2 years cycle
                $passedDays = max(0, $totalDays - $daysUntilKgb);
                $progressPercent = min(100, max(0, round(($passedDays / $totalDays) * 100)));
            } else {
                $daysUntilKgb = 0;
                $monthsUntilKgb = 0;
                $progressPercent = 100;
            }
        }

        return view('gtk.dashboard', compact(
            'pegawai',
            'latestUsulan',
            'usulanHistory',
            'signedSks',
            'estimatedNewSalary',
            'salaryIncrement',
            'yearlyIncrement',
            'daysUntilKgb',
            'monthsUntilKgb',
            'progressPercent'
        ));
    }

    public function profil()
    {
        $pegawai = $this->getPegawai();

        if (!$pegawai) {
            return redirect()->route('gtk.dashboard')
                ->with('error', 'Data pegawai tidak ditemukan atau belum terhubung dengan akun GTK.');
        }

        return view('gtk.profil', compact('pegawai'));
    }

    public function profilUpdate(Request $request)
    {
        $pegawai = $this->getPegawai();

        if (!$pegawai) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'pangkat_gol' => 'required|string|max:20',
            'unit_kerja' => 'required|string|max:150',
            'gaji_pokok_lama' => 'required|numeric|min:0',
            'mkg_tahun' => 'required|integer|min:0',
            'mkg_bulan' => 'required|integer|min:0|max:11',
            'tmt_kgb_terakhir' => 'required|date',
            'tmt_kgb_yad' => 'nullable|date',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            'password' => 'nullable|string|min:6',
        ], [
            'nama.required' => 'Nama pegawai wajib diisi.',
            'pangkat_gol.required' => 'Pangkat / Golongan wajib diisi.',
            'unit_kerja.required' => 'Unit kerja / sekolah wajib diisi.',
            'gaji_pokok_lama.required' => 'Gaji pokok lama wajib diisi.',
            'foto_profil.image' => 'File foto profil harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'foto_profil.max' => 'Ukuran foto profil maksimal 5 MB.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        if ($request->hasFile('foto_profil')) {
            $uploadDir = public_path('uploads/profil');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $pegawai->nip . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['foto_profil'] = 'uploads/profil/' . $filename;
        }

        $pegawai->update($validated);

        if ($request->filled('password')) {
            $user = Auth::user();
            if ($user) {
                $user->update([
                    'password' => \Illuminate\Support\Facades\Hash::make($request->password)
                ]);
            }
        }

        return back()->with('success', 'Data profil & foto pegawai berhasil diperbarui!');
    }

    public function usulanIndex()
    {
        $pegawai = $this->getPegawai();

        if (!$pegawai) {
            return redirect()->route('login')->with('error', 'Data pegawai tidak ditemukan.');
        }

        $latestUsulan = UsulanKgb::where('nip', $pegawai->nip)->with('skKgb')->latest()->first();
        $usulans = UsulanKgb::where('nip', $pegawai->nip)->with('skKgb')->latest()->paginate(10);

        return view('gtk.usulan', compact('pegawai', 'latestUsulan', 'usulans'));
    }

    public function usulanStore(Request $request)
    {
        $pegawai = $this->getPegawai();

        if (!$pegawai) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $request->validate([
            'periode_bulan' => 'required|integer|between:1,12',
            'periode_tahun' => 'required|integer|min:2020|max:2035',
            'gaji_pokok_baru' => 'required|numeric|min:0',
            'tmt_berlaku' => 'required|date',
            'mkg_baru_tahun' => 'required|integer|min:0',
            'mkg_baru_bulan' => 'required|integer|between:0,11',
            'catatan_admin' => 'nullable|string|max:500',
            'berkas_pdf.*' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $berkasPaths = [];
        if ($request->hasFile('berkas_pdf')) {
            $uploadDir = public_path('uploads/berkas_usulan');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            foreach ($request->file('berkas_pdf') as $file) {
                if ($file && $file->isValid()) {
                    $origName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = time() . '_' . Str::slug($origName) . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadDir, $filename);
                    $berkasPaths[] = [
                        'nama' => $file->getClientOriginalName(),
                        'path' => 'uploads/berkas_usulan/' . $filename,
                        'uploaded_at' => now()->toDateTimeString()
                    ];
                }
            }
        }

        $nomorUsulan = 'KGB/' . $request->periode_tahun . sprintf('%02d', $request->periode_bulan) . '/' . $pegawai->nip;

        UsulanKgb::create([
            'nip' => $pegawai->nip,
            'nomor_usulan' => $nomorUsulan,
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => $request->periode_tahun,
            'gaji_pokok_baru' => $request->gaji_pokok_baru,
            'tmt_berlaku' => $request->tmt_berlaku,
            'mkg_baru_tahun' => $request->mkg_baru_tahun,
            'mkg_baru_bulan' => $request->mkg_baru_bulan,
            'status' => 'verifikasi',
            'catatan_admin' => $request->catatan_admin ?? 'Usulan KGB Mandiri diajukan oleh pegawai GTK.',
            'berkas_pdf' => $berkasPaths
        ]);

        return back()->with('success', 'Usulan KGB Mandiri Anda berhasil diajukan dengan berkas PDF!');
    }

    public function downloadSk($id)
    {
        return redirect()->route('sk.download', $id);
    }
}
