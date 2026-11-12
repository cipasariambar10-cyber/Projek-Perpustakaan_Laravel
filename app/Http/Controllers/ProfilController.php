<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    /**
     * Form edit profil.
     */
    public function edit()
    {
        $user = auth()->user();

        return view('profil.edit', compact('user'));
    }

    /**
     * Perbarui profil.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp' => ['nullable', 'digits_between:10,13'],
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'no_hp.digits_between' => 'Nomor telepon harus berupa angka dengan panjang antara 10 hingga 13 digit.',
        ];

        if ($isAdmin) {
            $rules['nis_nip'] = ['nullable', 'string', 'max:30'];
            $rules['kelas'] = ['nullable', 'string', 'max:100'];
            $messages['nis_nip.max'] = 'NIP / Nomor Identitas maksimal 30 karakter.';
            $messages['kelas.max'] = 'Jabatan maksimal 100 karakter.';
        } else {
            $rules['nis_nip'] = ['nullable', 'digits:10'];
            $rules['kelas'] = ['nullable', 'string', 'max:20'];
            $messages['nis_nip.digits'] = 'NISN harus berupa angka dan terdiri dari tepat 10 digit.';
            $messages['kelas.max'] = 'Kelas maksimal 20 karakter.';
        }

        $validated = $request->validate($rules, $messages);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Form ganti password.
     */
    public function editPassword()
    {
        return view('profil.password');
    }

    /**
     * Proses ganti password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
