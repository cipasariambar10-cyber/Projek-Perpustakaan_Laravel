<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuKategoriTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    }

    private function buku(array $override = []): Book
    {
        $kategori = Category::firstOrCreate(['nama' => 'Novel']);

        return Book::create(array_merge([
            'category_id' => $kategori->id,
            'judul' => 'Laskar Pelangi',
            'pengarang' => 'Andrea Hirata',
            'penerbit' => 'Bentang',
            'tahun_terbit' => 2005,
            'isbn' => '111',
            'stok' => 5,
        ], $override));
    }

    public function test_tamu_tidak_bisa_masuk_halaman_admin(): void
    {
        $this->get('/admin/buku')->assertRedirect('/login');
        $this->get('/admin/kategori')->assertRedirect('/login');
    }

    public function test_anggota_tidak_bisa_masuk_halaman_admin(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'status' => 'aktif']);

        $this->actingAs($anggota)->get('/admin/buku')->assertForbidden();
    }

    public function test_dashboard_menampilkan_angka(): void
    {
        $this->buku();

        $this->actingAs($this->admin())->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Total Buku')
            ->assertSee('Total Anggota')
            ->assertSee('Sedang Dipinjam')
            ->assertSee('Terlambat');
    }

    public function test_crud_kategori(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/kategori')->assertOk();
        $this->actingAs($admin)->get('/admin/kategori/create')->assertOk();

        $this->actingAs($admin)->post('/admin/kategori', ['nama' => 'Uji Coba'])
            ->assertRedirect('/admin/kategori');
        $kategori = Category::where('nama', 'Uji Coba')->firstOrFail();

        $this->actingAs($admin)->get("/admin/kategori/{$kategori->id}/edit")->assertOk();
        $this->actingAs($admin)->put("/admin/kategori/{$kategori->id}", ['nama' => 'Uji Coba 2'])
            ->assertRedirect('/admin/kategori');
        $this->assertDatabaseHas('categories', ['nama' => 'Uji Coba 2']);

        $this->actingAs($admin)->delete("/admin/kategori/{$kategori->id}")
            ->assertRedirect('/admin/kategori');
        $this->assertDatabaseMissing('categories', ['id' => $kategori->id]);
    }

    public function test_kategori_duplikat_ditolak(): void
    {
        Category::create(['nama' => 'Novel']);

        $this->actingAs($this->admin())->post('/admin/kategori', ['nama' => 'Novel'])
            ->assertSessionHasErrors('nama');
    }

    public function test_kategori_yang_dipakai_tidak_bisa_dihapus(): void
    {
        $buku = $this->buku();

        $this->actingAs($this->admin())->delete("/admin/kategori/{$buku->category_id}")
            ->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $buku->category_id]);
    }

    public function test_crud_buku(): void
    {
        $admin = $this->admin();
        $kategori = Category::create(['nama' => 'Komik']);

        $this->actingAs($admin)->get('/admin/buku')->assertOk();
        $this->actingAs($admin)->get('/admin/buku/create')->assertOk();

        $this->actingAs($admin)->post('/admin/buku', [
            'category_id' => $kategori->id,
            'judul' => 'Buku Uji',
            'pengarang' => 'Penguji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => 2020,
            'isbn' => '1111111111',
            'stok' => 3,
            'lokasi_rak' => 'Z-01',
            'sinopsis' => 'Uji coba',
        ])->assertRedirect('/admin/buku');

        $buku = Book::where('judul', 'Buku Uji')->firstOrFail();

        $this->actingAs($admin)->get("/admin/buku/{$buku->id}/edit")->assertOk()->assertSee('Buku Uji');

        $this->actingAs($admin)->put("/admin/buku/{$buku->id}", [
            'category_id' => $kategori->id,
            'judul' => 'Buku Uji',
            'pengarang' => 'Penguji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => 2020,
            'isbn' => '1111111111',
            'stok' => 7,
        ])->assertRedirect('/admin/buku');
        $this->assertSame(7, $buku->fresh()->stok);

        $this->actingAs($admin)->delete("/admin/buku/{$buku->id}")->assertRedirect('/admin/buku');
        $this->assertDatabaseMissing('books', ['id' => $buku->id]);
    }

    public function test_validasi_buku(): void
    {
        $this->actingAs($this->admin())->post('/admin/buku', [])
            ->assertSessionHasErrors(['category_id', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'stok']);
    }

    public function test_katalog_pencarian_filter_dan_detail(): void
    {
        $novel = $this->buku();
        $komik = Category::create(['nama' => 'Komik']);
        $this->buku(['category_id' => $komik->id, 'judul' => 'Doraemon', 'pengarang' => 'Fujiko', 'isbn' => '222']);

        $this->get('/katalog')->assertOk()->assertSee('Laskar Pelangi')->assertSee('Doraemon');
        $this->get('/katalog?q=LASKAR')->assertOk()->assertSee('Laskar Pelangi')->assertDontSee('Doraemon');
        $this->get('/katalog?q=fujiko')->assertOk()->assertSee('Doraemon')->assertDontSee('Laskar Pelangi');
        $this->get('/katalog?kategori=' . $komik->id)->assertOk()->assertSee('Doraemon')->assertDontSee('Laskar Pelangi');
        $this->get("/katalog/{$novel->id}")->assertOk()->assertSee('Laskar Pelangi')->assertSee('Andrea Hirata');
    }
}
