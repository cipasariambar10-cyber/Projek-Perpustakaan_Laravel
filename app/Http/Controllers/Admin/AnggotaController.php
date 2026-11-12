<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AnggotaController extends Controller
{
    /**
     * Daftar semua anggota & admin.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan pencarian
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nis_nip', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan role
        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        // Filter berdasarkan status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $anggota = $query->orderBy('name')->paginate(6)->withQueryString();

        return view('admin.anggota.index', compact('anggota'));
    }

    /**
     * Form tambah anggota baru.
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Simpan anggota baru.
     */
    public function store(Request $request)
    {
        $isAdminRole = $request->input('role') === 'admin';

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', Rule::in(['admin', 'anggota'])],
            'no_hp' => ['nullable', 'digits_between:10,13'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_hp.digits_between' => 'Nomor telepon harus berupa angka dengan panjang antara 10 hingga 13 digit.',
        ];

        if ($isAdminRole) {
            $rules['nis_nip'] = ['nullable', 'string', 'max:30'];
            $rules['kelas'] = ['nullable', 'string', 'max:100'];
            $messages['nis_nip.max'] = 'NIP maksimal 30 karakter.';
            $messages['kelas.max'] = 'Jabatan maksimal 100 karakter.';
        } else {
            $rules['nis_nip'] = ['nullable', 'digits:10'];
            $rules['kelas'] = ['nullable', 'string', 'max:20'];
            $messages['nis_nip.digits'] = 'NISN harus berupa angka dan terdiri dari tepat 10 digit.';
            $messages['kelas.max'] = 'Kelas maksimal 20 karakter.';
        }

        $validated = $request->validate($rules, $messages);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Detail anggota.
     */
    public function show(User $anggotum)
    {
        $anggota = $anggotum;

        // Hitung statistik peminjaman jika tabel loans sudah ada
        $stats = [
            'total_pinjam' => 0,
            'sedang_dipinjam' => 0,
            'terlambat' => 0,
        ];

        try {
            if (\Schema::hasTable('loans')) {
                $stats['total_pinjam'] = $anggota->loans()->count();
                $stats['sedang_dipinjam'] = $anggota->loans()->where('status', 'dipinjam')->count();
                $stats['terlambat'] = $anggota->loans()
                    ->where('status', 'dipinjam')
                    ->where('batas_kembali', '<', now())
                    ->count();
            }
        } catch (\Exception $e) {
            // Tabel loans belum dibuat oleh Hayfa
        }

        return view('admin.anggota.show', compact('anggota', 'stats'));
    }

    /**
     * Form ubah anggota.
     */
    public function edit(User $anggotum)
    {
        $anggota = $anggotum;

        return view('admin.anggota.edit', compact('anggota'));
    }

    /**
     * Perbarui data anggota.
     */
    public function update(Request $request, User $anggotum)
    {
        $anggota = $anggotum;
        $isAdminRole = $request->input('role') === 'admin';

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($anggota->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role' => ['required', Rule::in(['admin', 'anggota'])],
            'no_hp' => ['nullable', 'digits_between:10,13'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_hp.digits_between' => 'Nomor telepon harus berupa angka dengan panjang antara 10 hingga 13 digit.',
        ];

        if ($isAdminRole) {
            $rules['nis_nip'] = ['nullable', 'string', 'max:30'];
            $rules['kelas'] = ['nullable', 'string', 'max:100'];
            $messages['nis_nip.max'] = 'NIP maksimal 30 karakter.';
            $messages['kelas.max'] = 'Jabatan maksimal 100 karakter.';
        } else {
            $rules['nis_nip'] = ['nullable', 'digits:10'];
            $rules['kelas'] = ['nullable', 'string', 'max:20'];
            $messages['nis_nip.digits'] = 'NISN harus berupa angka dan terdiri dari tepat 10 digit.';
            $messages['kelas.max'] = 'Kelas maksimal 20 karakter.';
        }

        $validated = $request->validate($rules, $messages);

        // Hanya update password jika diisi
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $anggota->update($validated);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Toggle status aktif/nonaktif.
     */
    public function toggleStatus(User $anggotum)
    {
        $anggota = $anggotum;

        // Jangan biarkan admin menonaktifkan diri sendiri
        if ($anggota->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $newStatus = $anggota->status === 'aktif' ? 'nonaktif' : 'aktif';
        $anggota->update(['status' => $newStatus]);

        $message = $newStatus === 'aktif'
            ? "Akun {$anggota->name} telah diaktifkan."
            : "Akun {$anggota->name} telah dinonaktifkan.";

        return back()->with('success', $message);
    }

    /**
     * Hapus anggota.
     */
    public function destroy(User $anggotum)
    {
        $anggota = $anggotum;

        if ($anggota->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($anggota->loans()->where('status', 'dipinjam')->exists()) {
            return back()->with('error', "Akun {$anggota->name} masih memiliki peminjaman buku yang aktif dan belum dikembalikan.");
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')
            ->with('success', "Akun {$anggota->name} telah dihapus.");
    }
}
