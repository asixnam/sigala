<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\UsulanKgb;
use App\Models\SkKgb;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    // Dashboard Utama Admin
    public function index()
    {
        $totalUsulan = UsulanKgb::count();
        $pendingVerifikasi = UsulanKgb::where('status', 'verifikasi')->count();
        $prosesTte = UsulanKgb::where('status', 'tte')->count();
        $skTerbit = UsulanKgb::where('status', 'selesai')->count();

        $recentUsulans = UsulanKgb::with('pegawai')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsulan',
            'pendingVerifikasi',
            'prosesTte',
            'skTerbit',
            'recentUsulans'
        ));
    }

    // Kelola Data GTK / Pegawai
    public function gtkIndex(Request $request)
    {
        $query = Pegawai::with(['usulanKgbs.skKgb']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($request->sort === 'desc') {
            $query->orderBy('nama', 'desc');
        } else {
            $query->orderBy('nama', 'asc');
        }

        if ($request->filled('unit_kerja')) {
            $query->where('unit_kerja', $request->unit_kerja);
        }

        $pegawais = $query->paginate(10)->withQueryString();
        $unitKerjaList = Pegawai::select('unit_kerja')->distinct()->pluck('unit_kerja');

        return view('admin.gtk', compact('pegawais', 'unitKerjaList'));
    }

    // Simpan Pegawai Baru
    public function gtkStore(Request $request)
    {
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
            'unit_kerja' => 'required|string|max:150',
        ]);

        $pegawai = Pegawai::create([
            'nip' => $validated['nip'],
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'gelar_depan' => $validated['gelar_depan'] ?? null,
            'gelar_belakang' => $validated['gelar_belakang'] ?? null,
            'jenis_pegawai' => $request->input('jenis_pegawai', 'guru'),
            'jabatan' => $request->input('jabatan') ?? null,
            'pangkat_gol' => $validated['pangkat_gol'],
            'gaji_pokok_lama' => $validated['gaji_pokok_lama'],
            'mkg_tahun' => (int)($validated['mkg_tahun'] ?? 0),
            'mkg_bulan' => (int)($validated['mkg_bulan'] ?? 0),
            'tmt_kgb_terakhir' => $validated['tmt_kgb_terakhir'],
            'tmt_kgb_yad' => $validated['tmt_kgb_yad'],
            'unit_kerja' => $validated['unit_kerja'],
        ]);


    $passwordPlain = !empty($validated['tanggal_lahir'])
        ? date('Ymd', strtotime($validated['tanggal_lahir']))
        : (strlen($pegawai->nip) >= 8
            ? substr($pegawai->nip, 0, 8)
            : '12345678');

    // Gunakan email dari form jika diisi, atau buat email otomatis
    $emailAkun = !empty($request->input('email'))
        ? $request->input('email')
        : strtolower(str_replace(' ', '', $pegawai->nama)) . rand(10, 99) . '@guru.test';

    User::updateOrCreate(
        ['username' => $pegawai->nip],
        [
            'email' => $emailAkun,
            'password' => Hash::make($passwordPlain),
            'role' => 'gtk',
            'nip_pegawai' => $pegawai->nip,
            'unit_kerja' => $pegawai->unit_kerja,
        ]
    );

    return back()->with(
        'success',
        "Data Pegawai {$pegawai->nama} berhasil ditambahkan!"
    );
}
    // Update Data Pegawai
        // Update Data Pegawai
        public function gtkUpdate(Request $request, $nip)
        {
            $pegawai = Pegawai::findOrFail($nip);

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
                'unit_kerja' => 'required|string|max:150',
            ]);

            $validated['mkg_tahun'] = (int)($validated['mkg_tahun'] ?? 0);
            $validated['mkg_bulan'] = (int)($validated['mkg_bulan'] ?? 0);

    // Update data pegawai
    $pegawai->update($validated);

    // Pastikan tanggal lahir benar-benar tersimpan
    \DB::table('pegawais')
        ->where('nip', $nip)
        ->update([
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_pegawai' => $validated['jenis_pegawai'] ?? null,
            'jabatan'       => $validated['jabatan'] ?? null,
            'updated_at'    => now(),
        ]);

    // Refresh data pegawai
    $pegawai->refresh();

    // Sinkronkan akun GTK
    User::where('nip_pegawai', $pegawai->nip)
        ->update([
            'unit_kerja' => $validated['unit_kerja'],
        ]);

            return back()->with(
                'success',
                "Data Pegawai {$pegawai->nama} berhasil diperbarui."
            );
        }

    // Hapus Pegawai
    public function gtkDestroy($nip)
    {
        $pegawai = Pegawai::findOrFail($nip);
        $nama = $pegawai->nama;

        // Hapus relasi SK KGB & Usulan KGB terlebih dahulu
        $usulanIds = UsulanKgb::where('nip', $nip)->pluck('id');
        if ($usulanIds->isNotEmpty()) {
            SkKgb::whereIn('usulan_id', $usulanIds)->delete();
            UsulanKgb::whereIn('id', $usulanIds)->delete();
        }

        // Delete user account if exists
        User::where('nip_pegawai', $nip)->delete();
        $pegawai->delete();

        return back()->with('success', "Data Pegawai {$nama} beserta riwayat usulannya berhasil dihapus.");
    }

    // Kelola Usulan KGB (Verifikasi, TTE & CRUD)
    public function usulanIndex(Request $request)
    {
        $query = UsulanKgb::with(['pegawai', 'skKgb'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pegawai', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            })->orWhere('nomor_usulan', 'like', "%{$search}%");
        }

        $usulans = $query->paginate(10)->withQueryString();
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();

        return view('admin.usulan', compact('usulans', 'pegawais'));
    }

    // Tambah Usulan KGB Baru
    public function usulanStore(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|exists:pegawais,nip',
            'periode_bulan' => 'required|integer|min:1|max:12',
            'periode_tahun' => 'required|integer|min:2000',
            'gaji_pokok_baru' => 'required|numeric|min:0',
            'mkg_baru_tahun' => 'required|integer|min:0',
            'mkg_baru_bulan' => 'required|integer|min:0|max:11',
            'tmt_berlaku' => 'required|date',
            'status' => 'nullable|in:draft,verifikasi,disetujui,tte,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
            'berkas_pdf.*' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $validated['status'] = $request->input('status', 'verifikasi');

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

        $validated['nomor_usulan'] = 'US-KGB-' . date('Ym') . '-' . rand(100, 999);
        $validated['berkas_pdf'] = $berkasPaths;

        $usulan = UsulanKgb::create($validated);

        return back()->with('success', "Usulan KGB nomor {$usulan->nomor_usulan} berhasil dibuat dengan berkas PDF!");
    }

    // Edit Usulan KGB
    public function usulanUpdate(Request $request, $id)
    {
        $usulan = UsulanKgb::findOrFail($id);

        $validated = $request->validate([
            'gaji_pokok_baru' => 'required|numeric|min:0',
            'mkg_baru_tahun' => 'required|integer|min:0',
            'mkg_baru_bulan' => 'required|integer|min:0|max:11',
            'tmt_berlaku' => 'required|date',
            'status' => 'required|in:draft,verifikasi,disetujui,tte,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
            'berkas_pdf.*' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $existingBerkas = $usulan->berkas_pdf ?? [];
        if (!is_array($existingBerkas)) {
            $existingBerkas = [];
        }

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
                    $existingBerkas[] = [
                        'nama' => $file->getClientOriginalName(),
                        'path' => 'uploads/berkas_usulan/' . $filename,
                        'uploaded_at' => now()->toDateTimeString()
                    ];
                }
            }
        }

        $validated['berkas_pdf'] = $existingBerkas;
        $usulan->update($validated);

        return back()->with('success', "Data Usulan KGB {$usulan->nomor_usulan} berhasil diperbarui!");
    }

    // Hapus Usulan KGB
    public function usulanDestroy($id)
    {
        $usulan = UsulanKgb::findOrFail($id);
        $nomorUsulan = $usulan->nomor_usulan;

        if ($usulan->skKgb) {
            $usulan->skKgb()->delete();
        }

        $usulan->delete();

        return back()->with('success', "Usulan KGB {$nomorUsulan} berhasil dihapus.");
    }

    // Update Status Usulan (Verifikasi / Setujui / Tolak / TTE)
    public function usulanUpdateStatus(Request $request, $id)
    {
        $usulan = UsulanKgb::findOrFail($id);
        $user = Auth::user();

        // Otorisasi role: Admin Sekolah hanya boleh memproses sampai 'verifikasi'
        if ($user && $user->role === 'admin_sekolah') {
            if ($usulan->pegawai && $usulan->pegawai->unit_kerja !== $user->unit_kerja) {
                abort(403, 'Anda tidak memiliki wewenang untuk mengedit usulan sekolah lain.');
            }
            $validated = $request->validate([
                'status' => 'required|in:draft,verifikasi',
                'catatan_admin' => 'nullable|string',
            ], [
                'status.in' => 'Admin Sekolah hanya berhak memproses usulan hingga tahap Verifikasi Berkas.',
            ]);
        } else {
            $validated = $request->validate([
                'status' => 'required|in:draft,verifikasi,disetujui,tte,selesai,ditolak',
                'catatan_admin' => 'nullable|string',
            ]);
        }

        $usulan->update($validated);

        return back()->with('success', "Status Usulan {$usulan->nomor_usulan} berhasil diperbarui menjadi: " . strtoupper($usulan->status));
    }

    // Terbitkan SK KGB (TTE) - Khusus Superadmin / Dinas / TTE
    public function usulanGenerateSk(Request $request, $id)
    {
        $user = Auth::user();
        if ($user && !in_array($user->role, ['superadmin', 'admin_dinas', 'admin_tte'])) {
            abort(403, 'Hanya Admin Dinas / Superadmin yang berhak menerbitkan SK KGB & TTE.');
        }

        $usulan = UsulanKgb::findOrFail($id);
        $pegawai = $usulan->pegawai;
        $isTeknisi = $pegawai && ($pegawai->is_teknisi || strtolower($pegawai->jenis_pegawai ?? '') === 'teknisi');
        $formatSk = $isTeknisi ? 'teknisi' : 'guru';

        $nomorSk = $isTeknisi
            ? '800.1.11.3/V/' . rand(1000, 9999) . '/' . date('Y')
            : '800.1.11.13/VI/' . rand(1000, 9999);

        $qrToken = 'QR-SIGALA-' . ($isTeknisi ? 'TEKNISI-' : 'GURU-') . strtoupper(Str::random(10));

        SkKgb::updateOrCreate(
            ['usulan_id' => $usulan->id],
            [
                'nomor_sk' => $nomorSk,
                'format_sk' => $formatSk,
                'tanggal_sk' => now()->toDateString(),
                'penandatangan_nama' => $isTeknisi ? 'SUNARYO' : 'SUNARYO, S.Pd., M.Si.',
                'penandatangan_nip' => '197003111994121002',
                'penandatangan_pangkat' => 'Pembina Utama Muda',
                'penandatangan_jabatan' => $isTeknisi
                    ? 'a.n SEKRETARIS DAERAH KABUPATEN BLORA KEPALA DINAS PENDIDIKAN KABUPATEN BLORA'
                    : 'Kepala Dinas Pendidikan Kabupaten Blora',
                'file_pdf_path' => 'sk_kgb_' . $usulan->nip . '.pdf',
                'file_tte_path' => 'sk_kgb_' . $usulan->nip . '_signed.pdf',
                'status_tte' => 'signed',
                'qr_code_token' => $qrToken,
            ]
        );

        $usulan->update([
            'status' => 'selesai',
            'catatan_admin' => 'SK KGB resmi telah disahkan TTE Kadis Pendidikan.'
        ]);

        return back()->with('success', "SK KGB Nomor {$nomorSk} telah berhasil diterbitkan dan disahkan!");
    }

    // Daftar Sekolah
    // public function sekolahIndex(Request $request)
    // {
    //     $query = User::where('role', 'admin_sekolah');

    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where(function ($q) use ($search) {
    //             $q->where('unit_kerja', 'like', "%{$search}%")
    //               ->orWhere('email', 'like', "%{$search}%")
    //               ->orWhere('username', 'like', "%{$search}%");
    //         });
    //     }

    //     $schoolAccounts = $query->get();

    //     $schools = $schoolAccounts->map(function ($acc) {
    //         $acc->total_pegawai = Pegawai::where('unit_kerja', $acc->unit_kerja)->count();
    //         return $acc;
    //     });

    //     // Pick up unit_kerja in Pegawai table not yet assigned an admin account
    //     $existingUnits = $schoolAccounts->pluck('unit_kerja')->toArray();
    //     $orphanQuery = Pegawai::whereNotIn('unit_kerja', $existingUnits)
    //         ->select('unit_kerja')
    //         ->selectRaw('count(*) as total_pegawai')
    //         ->groupBy('unit_kerja');

    //     if ($request->filled('search')) {
    //         $orphanQuery->having('unit_kerja', 'like', "%{$request->search}%");
    //     }

    //     foreach ($orphanQuery->get() as $orphan) {
    //         $dummy = new User([
    //             'unit_kerja' => $orphan->unit_kerja,
    //             'email' => '-',
    //             'username' => 'Belum Ada Akun',
    //         ]);
    //         $dummy->total_pegawai = $orphan->total_pegawai;
    //         $schools->push($dummy);
    //     }

    //     return view('admin.sekolah', compact('schools'));
    // }
    public function sekolahIndex(Request $request)
{
    $query = User::where('role', 'admin_sekolah');

    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($q) use ($search) {
            $q->where('unit_kerja', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%");
        });
    }

    $schoolAccounts = $query
        ->orderBy('unit_kerja', 'asc')
        ->get();

    $schools = $schoolAccounts->map(function ($acc) {

        /*
         * Hitung jumlah pegawai berdasarkan unit kerja.
         */
        $acc->total_pegawai = $acc->unit_kerja
            ? Pegawai::where('unit_kerja', $acc->unit_kerja)->count()
            : 0;

        /*
         * Jika unit_kerja kosong, gunakan username sebagai
         * fallback sementara agar kartu tidak kosong.
         */
        if (empty($acc->unit_kerja)) {
            $acc->display_name = ucwords(
                str_replace(
                    ['-', '_'],
                    ' ',
                    $acc->username
                )
            );
        } else {
            $acc->display_name = $acc->unit_kerja;
        }

        return $acc;
    });

    /*
     * Ambil unit kerja dari tabel pegawai yang belum mempunyai
     * akun admin_sekolah.
     */
    $existingUnits = $schoolAccounts
        ->pluck('unit_kerja')
        ->filter()
        ->toArray();

    $orphanQuery = Pegawai::whereNotNull('unit_kerja')
        ->whereNotIn('unit_kerja', $existingUnits)
        ->select('unit_kerja')
        ->selectRaw('COUNT(*) as total_pegawai')
        ->groupBy('unit_kerja');

    if ($request->filled('search')) {
        $search = trim($request->search);

        $orphanQuery->having(
            'unit_kerja',
            'like',
            "%{$search}%"
        );
    }

    foreach ($orphanQuery->get() as $orphan) {

        $dummy = new User([
            'unit_kerja' => $orphan->unit_kerja,
            'email' => '-',
            'username' => 'Belum Ada Akun',
        ]);

        $dummy->display_name = $orphan->unit_kerja;
        $dummy->total_pegawai = $orphan->total_pegawai;

        $schools->push($dummy);
    }

    return view('admin.sekolah', compact('schools'));
}

    // Tambah / Buat Akun Sekolah Baru (Pembaruan Otomatis Jika Unit Kerja Sudah Ada)
    public function sekolahStore(Request $request)
    {
        $existingUser = User::where('unit_kerja', $request->unit_kerja)->first();

        if ($existingUser) {
            // Jika akun sekolah dengan unit_kerja tersebut sudah ada, perbarui akun & gambarnya
            $validated = $request->validate([
                'unit_kerja' => 'required|string|max:150',
                'username' => 'required|string|max:50|unique:users,username,' . $existingUser->id,
                'email' => 'required|email|max:100|unique:users,email,' . $existingUser->id,
                'password' => 'nullable|string|min:6',
                'logo_sekolah' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            ], [
                'username.unique' => 'Username admin ini sudah digunakan oleh akun lain.',
                'email.unique' => 'Email sekolah ini sudah digunakan oleh akun lain.',
                'logo_sekolah.image' => 'File logo harus berupa gambar (JPG, PNG, WEBP, SVG).',
                'logo_sekolah.max' => 'Ukuran file foto maksimal 5 MB.',
            ]);

            $updateData = [
                'unit_kerja' => $validated['unit_kerja'],
                'username' => $validated['username'],
                'email' => $validated['email'],
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

            $existingUser->update($updateData);

            return back()->with('success', "Akun & foto profil Sekolah '{$validated['unit_kerja']}' berhasil diperbarui!");
        }

        // Jika belum ada akun, buat akun baru
        $validated = $request->validate([
            'unit_kerja' => 'required|string|max:150|unique:users,unit_kerja',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'logo_sekolah' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
        ], [
            'unit_kerja.unique' => 'Nama unit kerja / sekolah sudah terdaftar di sistem.',
            'username.unique' => 'Username admin ini sudah digunakan oleh akun lain.',
            'email.unique' => 'Email sekolah ini sudah digunakan oleh akun lain.',
            'logo_sekolah.image' => 'File logo harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'logo_sekolah.max' => 'Ukuran file foto maksimal 5 MB.',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo_sekolah')) {
            $uploadDir = public_path('uploads/sekolah');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('logo_sekolah');
            $filename = time() . '_' . Str::slug($validated['unit_kerja']) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $logoPath = 'uploads/sekolah/' . $filename;
        }

        $userData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin_sekolah',
            'unit_kerja' => $validated['unit_kerja'],
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'logo_sekolah')) {
            $userData['logo_sekolah'] = $logoPath;
        }

        User::create($userData);

        return back()->with('success', "Sekolah '{$validated['unit_kerja']}' dan akun Admin Sekolah berhasil dibuat!");
    }

    // Edit Sekolah & Akun Admin
    public function sekolahUpdate(Request $request, $id)
    {
        $schoolUser = User::findOrFail($id);
        $oldUnit = $schoolUser->unit_kerja;

        $validated = $request->validate([
            'unit_kerja' => 'required|string|max:150|unique:users,unit_kerja,' . $id,
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'logo_sekolah' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
        ], [
            'unit_kerja.unique' => 'Nama unit kerja / sekolah sudah terdaftar di sistem.',
            'username.unique' => 'Username admin ini sudah digunakan oleh akun lain.',
            'email.unique' => 'Email sekolah ini sudah digunakan oleh akun lain.',
            'logo_sekolah.image' => 'File logo harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'logo_sekolah.max' => 'Ukuran file foto maksimal 5 MB.',
        ]);

        $updateData = [
            'unit_kerja' => $validated['unit_kerja'],
            'username' => $validated['username'],
            'email' => $validated['email'],
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

        $schoolUser->update($updateData);

        // Synchronize pegawais unit_kerja if renamed
        if ($oldUnit && $oldUnit !== $validated['unit_kerja']) {
            Pegawai::where('unit_kerja', $oldUnit)->update(['unit_kerja' => $validated['unit_kerja']]);
        }

        return back()->with('success', "Data Sekolah '{$validated['unit_kerja']}' berhasil diperbarui!");
    }

    // Hapus Sekolah & Akun Admin
    public function sekolahDestroy($id)
    {
        $schoolUser = User::findOrFail($id);
        $unitKerja = $schoolUser->unit_kerja;

        $schoolUser->delete();

        return back()->with('success', "Akun Admin Sekolah '{$unitKerja}' berhasil dihapus.");
    }
}
