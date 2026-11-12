<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAnggotaTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);
    }

    public function test_tabel_index_menampilkan_judul_kolom_nisn_nip_dan_kelas_jabatan(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->get(route('admin.anggota.index'));

        $response->assertOk();
        $response->assertSee('NISN / NIP');
        $response->assertSee('Kelas / Jabatan');
    }

    public function test_admin_bisa_menambah_admin_baru_dengan_nip_dan_jabatan(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('admin.anggota.store'), [
            'name' => 'Petugas Baru',
            'email' => 'petugas@perpus.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
            'nis_nip' => '199001012020121002',
            'kelas' => 'Pengelola Perpustakaan',
            'no_hp' => '081234567890',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.anggota.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'petugas@perpus.com',
            'role' => 'admin',
            'nis_nip' => '199001012020121002',
            'kelas' => 'Pengelola Perpustakaan',
        ]);
    }

    public function test_admin_bisa_menambah_anggota_baru_dengan_nisn_10_digit_dan_kelas(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('admin.anggota.store'), [
            'name' => 'Siswa Baru',
            'email' => 'siswa@perpus.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'anggota',
            'nis_nip' => '0012345678',
            'kelas' => 'XII PPLG 1',
            'no_hp' => '081234567891',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.anggota.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'siswa@perpus.com',
            'role' => 'anggota',
            'nis_nip' => '0012345678',
            'kelas' => 'XII PPLG 1',
        ]);
    }

    public function test_validasi_nisn_gagal_jika_role_anggota_dan_nisn_bukan_10_digit(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('admin.anggota.store'), [
            'name' => 'Siswa Salah NISN',
            'email' => 'siswa_salah@perpus.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'anggota',
            'nis_nip' => '12345',
            'kelas' => 'XII PPLG 1',
            'status' => 'aktif',
        ]);

        $response->assertSessionHasErrors(['nis_nip']);
    }

    public function test_admin_bisa_mengubah_data_anggota_menjadi_admin_dengan_nip_dan_jabatan(): void
    {
        $admin = $this->admin();
        $anggota = User::factory()->create([
            'role' => 'anggota',
            'status' => 'aktif',
            'nis_nip' => '0012345678',
            'kelas' => 'XII PPLG 1',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.anggota.update', $anggota), [
            'name' => 'Anggota Dipromosikan',
            'email' => $anggota->email,
            'role' => 'admin',
            'nis_nip' => '198801012015011003',
            'kelas' => 'Pustakawan',
            'no_hp' => '081234567899',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.anggota.index'));
        $anggota->refresh();
        $this->assertSame('admin', $anggota->role);
        $this->assertSame('198801012015011003', $anggota->nis_nip);
        $this->assertSame('Pustakawan', $anggota->kelas);
    }

    public function test_halaman_show_menampilkan_label_sesuai_role(): void
    {
        $admin = $this->admin();
        $adminTarget = User::factory()->create([
            'role' => 'admin',
            'nis_nip' => '198501012010011001',
            'kelas' => 'Pengelola Perpustakaan',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.anggota.show', $adminTarget));
        $response->assertOk();
        $response->assertSee('NIP');
        $response->assertSee('Jabatan');
        $response->assertSee('Pengelola Perpustakaan');
    }
}
