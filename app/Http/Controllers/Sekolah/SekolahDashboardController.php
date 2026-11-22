<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\UsulanKgb;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SekolahDashboardController extends Controller
{
    private function getUnitKerja()
    {
        return Auth::user()->unit_kerja ?? 'SD Negeri 1 Blora';
    }

    public function index()
    {
        $unitKerja = $this->getUnitKerja();

        $totalGtk = Pegawai::where('unit_kerja', $unitKerja)->count();
        $upcomingKgb = Pegawai::where('unit_kerja', $unitKerja)
            ->whereBetween('tmt_kgb_yad', [now()->toDateString(), now()->addDays(60)->toDateString()])
            ->count();
        $diprosesDinas = UsulanKgb::whereHas('pegawai', function ($q) use ($unitKerja) {
            $q->where('unit_kerja', $unitKerja);
        })->whereIn('status', ['verifikasi', 'disetujui', 'tte'])->count();

        $skSelesai = UsulanKgb::whereHas('pegawai', function ($q) use ($unitKerja) {
            $q->where('unit_kerja', $unitKerja);
        })->where('status', 'selesai')->count();

        $usulans = UsulanKgb::whereHas('pegawai', function ($q) use ($unitKerja) {
            $q->where('unit_kerja', $unitKerja);
        })->with(['pegawai', 'skKgb'])->latest()->paginate(10);

        $schoolPegawais = Pegawai::where('unit_kerja', $unitKerja)->get();

        return view('sekolah.dashboard', compact(
            'unitKerja',
            'totalGtk',
            'upcomingKgb',
            'diprosesDinas',
            'skSelesai',
            'usulans',
            'schoolPegawais'
        ));
    }

    // Submit new Usulan KGB for a GTK in the school
    public function usulanStore(Request $request)
    {
        $unitKerja = $this->getUnitKerja();

        $validated = $request->validate([
            'nip' => 'required|exists:pegawais,nip',
            'periode_bulan' => 'required|integer|min:1|max:12',
            'periode_tahun' => 'required|integer|min:2024|max:2030',
            'gaji_pokok_baru' => 'required|numeric|min:0',
            'mkg_baru_tahun' => 'required|integer|min:0',
            'mkg_baru_bulan' => 'required|integer|min:0|max:11',
            'tmt_berlaku' => 'required|date',
            'catatan_admin' => 'nullable|string',
            'berkas_pdf.*' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $pegawai = Pegawai::where('nip', $validated['nip'])->where('unit_kerja', $unitKerja)->firstOrFail();

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

        $nomorUsulan = 'USULAN/KGB/' . $validated['periode_tahun'] . '/' . sprintf('%03d', rand(100, 999));

        UsulanKgb::create([
            'nip' => $pegawai->nip,
            'nomor_usulan' => $nomorUsulan,
            'periode_bulan' => $validated['periode_bulan'],
            'periode_tahun' => $validated['periode_tahun'],
            'gaji_pokok_baru' => $validated['gaji_pokok_baru'],
            'mkg_baru_tahun' => $validated['mkg_baru_tahun'],
            'mkg_baru_bulan' => $validated['mkg_baru_bulan'],
            'tmt_berlaku' => $validated['tmt_berlaku'],
            'status' => 'verifikasi',
            'catatan_admin' => $validated['catatan_admin'] ?? 'Diajukan oleh Admin Sekolah ' . $unitKerja,
            'berkas_pdf' => $berkasPaths
        ]);

        return back()->with('success', "Usulan KGB untuk {$pegawai->nama} berhasil diajukan ke Dinas dengan berkas PDF!");
    }

    // Data GTK Sekolah
    public function gtkIndex(Request $request)
    {
        $unitKerja = $this->getUnitKerja();
        $query = Pegawai::where('unit_kerja', $unitKerja)->with(['usulanKgbs.skKgb']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $pegawais = $query->paginate(10)->withQueryString();

        return view('sekolah.gtk', compact('unitKerja', 'pegawais'));
    }

    // Input GTK Sekolah
    public function gtkStore(Request $request)
    {
        $unitKerja = $this->getUnitKerja();

        $request->merge([
            'mkg_tahun' => is_numeric($request->input('mkg_tahun')) ? (int)$request->input('mkg_tahun') : 0,
            'mkg_bulan' => is_numeric($request->input('mkg_bulan')) ? (int)$request->input('mkg_bulan') : 0,
        ]);

        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:pegawais,nip',
            'nama' => 'required|string|max:150',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'nullable|email|max:150',
            'gelar_depan' => 'nullable|string|max:20',
            'gelar_belakang' => 'nullable|string|max:20',
            'jenis_pegawai' => 'nullable|in:guru,teknisi',
            'jabatan' => 'nullable|string|max:150',
            'pangkat_gol' => 'required|string|max:10',
            'gaji_pokok_lama' => 'required|numeric|min:0',
            'mkg_tahun' => 'nullable|integer|min:0',
            'mkg_bulan' => 'nullable|integer|min:0|max:11',
            'tmt_kgb_terakhir' => 'required|date',
            'tmt_kgb_yad' => 'required|date',
        ]);

        $validated['mkg_tahun'] = (int)($validated['mkg_tahun'] ?? 0);
        $validated['mkg_bulan'] = (int)($validated['mkg_bulan'] ?? 0);
        $validated['unit_kerja'] = $unitKerja;
        $validated['jenis_pegawai'] = $request->input('jenis_pegawai', 'guru');
        $validated['jabatan'] = $request->input('jabatan') ?? null;

        if (!\Illuminate\Support\Facades\Schema::hasColumn('pegawais', 'tanggal_lahir')) {
            unset($validated['tanggal_lahir']);
        }

        // Remove email from validated array before creating pegawai (not a pegawai field)
        $emailAkun = $validated['email'] ?? null;
        unset($validated['email']);

        $pegawai = Pegawai::create($validated);

        // Password = Tanggal lahir (YYYYMMDD) or NIP 8 digits
        $passwordPlain = $request->tanggal_lahir 
            ? date('Ymd', strtotime($request->tanggal_lahir)) 
            : (strlen($request->nip) >= 8 ? substr($request->nip, 0, 8) : '12345678');

        // Gunakan email dari form jika diisi, atau buat email otomatis
        if (empty($emailAkun)) {
            $emailAkun = strtolower(str_replace(' ', '', $pegawai->nama)) . rand(10, 99) . '@guru.test';
        }

        User::updateOrCreate(
            ['username' => $pegawai->nip],
            [
                'email' => $emailAkun,
                'password' => Hash::make($passwordPlain),
                'role' => 'gtk',
                'nip_pegawai' => $pegawai->nip,
                'unit_kerja' => $unitKerja,
            ]
        );

        return back()->with('success', "Data GTK {$pegawai->nama} berhasil ditambahkan!");
    }

    // Edit GTK Sekolah
    public function gtkUpdate(Request $request, $nip)
    {
        $unitKerja = $this->getUnitKerja();
        $pegawai = Pegawai::where('nip', $nip)->where('unit_kerja', $unitKerja)->firstOrFail();

        $request->merge([
            'mkg_tahun' => is_numeric($request->input('mkg_tahun')) ? (int)$request->input('mkg_tahun') : 0,
            'mkg_bulan' => is_numeric($request->input('mkg_bulan')) ? (int)$request->input('mkg_bulan') : 0,
        ]);

        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'tanggal_lahir' => 'nullable|date',
            'gelar_depan' => 'nullable|string|max:20',
            'gelar_belakang' => 'nullable|string|max:20',
            'jenis_pegawai' => 'nullable|in:guru,teknisi',
            'jabatan' => 'nullable|string|max:150',
            'pangkat_gol' => 'required|string|max:10',
            'gaji_pokok_lama' => 'required|numeric|min:0',
            'mkg_tahun' => 'nullable|integer|min:0',
            'mkg_bulan' => 'nullable|integer|min:0|max:11',
            'tmt_kgb_terakhir' => 'required|date',
            'tmt_kgb_yad' => 'required|date',
        ]);

        $validated['mkg_tahun'] = (int)($validated['mkg_tahun'] ?? 0);
        $validated['mkg_bulan'] = (int)($validated['mkg_bulan'] ?? 0);

        if (!\Illuminate\Support\Facades\Schema::hasColumn('pegawais', 'tanggal_lahir')) {
            unset($validated['tanggal_lahir']);
        }

        $pegawai->update($validated);

        return back()->with('success', "Data GTK {$pegawai->nama} berhasil diperbarui.");
    }

    // Hapus GTK Sekolah
    public function gtkDestroy($nip)
    {
        $unitKerja = $this->getUnitKerja();
        $pegawai = Pegawai::where('nip', $nip)->where('unit_kerja', $unitKerja)->firstOrFail();
        $nama = $pegawai->nama;

        User::where('nip_pegawai', $nip)->delete();
        $pegawai->delete();

        return back()->with('success', "Data GTK {$nama} berhasil dihapus.");
    }

    // Kelola Usulan KGB Sekolah
    public function usulanIndex(Request $request)
    {
        $unitKerja = $this->getUnitKerja();
        $query = UsulanKgb::whereHas('pegawai', function ($q) use ($unitKerja) {
            $q->where('unit_kerja', $unitKerja);
        })->with(['pegawai', 'skKgb'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pegawai', function ($pq) use ($search) {
                    $pq->where('nama', 'like', "%{$search}%")
                       ->orWhere('nip', 'like', "%{$search}%");
                })->orWhere('nomor_usulan', 'like', "%{$search}%");
            });
        }

        $usulans = $query->paginate(10)->withQueryString();
        $schoolPegawais = Pegawai::where('unit_kerja', $unitKerja)->orderBy('nama', 'asc')->get();

        return view('sekolah.usulan', compact('unitKerja', 'usulans', 'schoolPegawais'));
    }

    // Profil Sekolah
    public function profil()
    {
        $user = Auth::user();
        $unitKerja = $this->getUnitKerja();
        $totalPegawai = Pegawai::where('unit_kerja', $unitKerja)->count();

        return view('sekolah.profil', compact('user', 'unitKerja', 'totalPegawai'));
    }

    // Update Profil Sekolah
    public function profilUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'unit_kerja' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'logo_sekolah' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
        ], [
            'unit_kerja.required' => 'Nama unit kerja / sekolah wajib diisi.',
            'username.unique' => 'Username admin ini sudah digunakan oleh akun lain.',
            'email.unique' => 'Email sekolah ini sudah digunakan oleh akun lain.',
            'logo_sekolah.image' => 'File logo harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'logo_sekolah.max' => 'Ukuran foto logo maksimal 5 MB.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $updateData = [
            'unit_kerja' => $validated['unit_kerja'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('logo_sekolah')) {
            $uploadDir = public_path('uploads/sekolah');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('logo_sekolah');
            $filename = time() . '_' . Str::slug($validated['unit_kerja']) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'logo_sekolah')) {
                $updateData['logo_sekolah'] = 'uploads/sekolah/' . $filename;
            }
        }

        $oldUnit = $user->unit_kerja;
        $user->update($updateData);

        if ($oldUnit && $oldUnit !== $validated['unit_kerja']) {
            Pegawai::where('unit_kerja', $oldUnit)->update(['unit_kerja' => $validated['unit_kerja']]);
        }

        return back()->with('success', 'Profil Sekolah & foto logo berhasil diperbarui!');
    }
}
