<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_melihat_label_nip_dan_jabatan(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
            'nis_nip' => '198501012010011001',
            'kelas' => 'Pengelola Perpustakaan',
        ]);

        $response = $this->actingAs($admin)->get('/profil');

        $response->assertOk();
        $response->assertSee('NIP / Nomor Identitas');
        $response->assertSee('Jabatan');
        $response->assertSee('Pengelola Perpustakaan');
    }

    public function test_admin_bisa_memperbarui_nip_dan_jabatan(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->put('/profil', [
            'name' => 'Admin Kepala',
            'email' => $admin->email,
            'nis_nip' => '198501012010011001',
            'kelas' => 'Pengelola Perpustakaan',
            'no_hp' => '081234567890',
        ]);

        $response->assertSessionHas('success');
        $admin->refresh();
        $this->assertSame('Admin Kepala', $admin->name);
        $this->assertSame('198501012010011001', $admin->nis_nip);
        $this->assertSame('Pengelola Perpustakaan', $admin->kelas);
    }

    public function test_anggota_melihat_label_nisn_dan_kelas(): void
    {
        $anggota = User::factory()->create([
            'role' => 'anggota',
            'status' => 'aktif',
            'nis_nip' => '0012345678',
            'kelas' => 'XII PPLG 1',
        ]);

        $response = $this->actingAs($anggota)->get('/profil');

        $response->assertOk();
        $response->assertSee('NISN');
        $response->assertSee('Kelas');
        $response->assertSee('XII PPLG 1');
    }

    public function test_anggota_bisa_memperbarui_nisn_dan_kelas(): void
    {
        $anggota = User::factory()->create([
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($anggota)->put('/profil', [
            'name' => 'Siswa Baru',
            'email' => $anggota->email,
            'nis_nip' => '1234567890',
            'kelas' => 'XII PPLG 2',
            'no_hp' => '081234567891',
        ]);

        $response->assertSessionHas('success');
        $anggota->refresh();
        $this->assertSame('Siswa Baru', $anggota->name);
        $this->assertSame('1234567890', $anggota->nis_nip);
        $this->assertSame('XII PPLG 2', $anggota->kelas);
    }

    public function test_anggota_gagal_update_jika_nisn_bukan_10_digit(): void
    {
        $anggota = User::factory()->create([
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($anggota)->put('/profil', [
            'name' => 'Siswa Error',
            'email' => $anggota->email,
            'nis_nip' => '12345',
            'kelas' => 'XII PPLG 1',
        ]);

        $response->assertSessionHasErrors(['nis_nip']);
    }
}
