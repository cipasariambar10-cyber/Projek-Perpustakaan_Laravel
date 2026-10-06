<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriList = ['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Pendidikan', 'Anak'];
        $categories = [];

        foreach ($kategoriList as $kat) {
            $categories[$kat] = Category::firstOrCreate([
                'nama' => $kat,
                'slug' => Str::slug($kat)
            ]);
        }

        $bukuContoh = [
            // Fiksi
            ['category' => 'Fiksi', 'judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun_terbit' => '1980', 'stok' => 5],
            ['category' => 'Fiksi', 'judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => '2005', 'stok' => 3],
            ['category' => 'Fiksi', 'judul' => 'Cantik Itu Luka', 'pengarang' => 'Eka Kurniawan', 'penerbit' => 'Gramedia', 'tahun_terbit' => '2002', 'stok' => 0],
            ['category' => 'Fiksi', 'judul' => 'Pulang', 'pengarang' => 'Leila S. Chudori', 'penerbit' => 'KPG', 'tahun_terbit' => '2012', 'stok' => 4],
            ['category' => 'Fiksi', 'judul' => 'Laut Bercerita', 'pengarang' => 'Leila S. Chudori', 'penerbit' => 'KPG', 'tahun_terbit' => '2017', 'stok' => 7],
            
            // Non-Fiksi
            ['category' => 'Non-Fiksi', 'judul' => 'Filosofi Teras', 'pengarang' => 'Henry Manampiring', 'penerbit' => 'Kompas', 'tahun_terbit' => '2018', 'stok' => 10],
            ['category' => 'Non-Fiksi', 'judul' => 'Sebuah Seni untuk Bersikap Bodo Amat', 'pengarang' => 'Mark Manson', 'penerbit' => 'Grasindo', 'tahun_terbit' => '2016', 'stok' => 2],
            ['category' => 'Non-Fiksi', 'judul' => 'Sapiens: Riwayat Singkat Umat Manusia', 'pengarang' => 'Yuval Noah Harari', 'penerbit' => 'KPG', 'tahun_terbit' => '2011', 'stok' => 5],
            ['category' => 'Non-Fiksi', 'judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'penerbit' => 'Gramedia', 'tahun_terbit' => '2018', 'stok' => 8],
            
            // Sains & Teknologi
            ['category' => 'Sains', 'judul' => 'Kosmos', 'pengarang' => 'Carl Sagan', 'penerbit' => 'KPG', 'tahun_terbit' => '1980', 'stok' => 4],
            ['category' => 'Sains', 'judul' => 'Asal Usul Spesies', 'pengarang' => 'Charles Darwin', 'penerbit' => 'Indoliterasi', 'tahun_terbit' => '1859', 'stok' => 2],
            ['category' => 'Teknologi', 'judul' => 'Belajar Coding untuk Pemula', 'pengarang' => 'Budi Raharjo', 'penerbit' => 'Informatika', 'tahun_terbit' => '2020', 'stok' => 15],
            ['category' => 'Teknologi', 'judul' => 'Mastering Laravel', 'pengarang' => 'Taylor Otwell', 'penerbit' => 'O\'Reilly', 'tahun_terbit' => '2023', 'stok' => 6],
            ['category' => 'Teknologi', 'judul' => 'Mengenal Artificial Intelligence', 'pengarang' => 'John McCarthy', 'penerbit' => 'Tech Press', 'tahun_terbit' => '2021', 'stok' => 3],
            
            // Sejarah
            ['category' => 'Sejarah', 'judul' => 'Sejarah Nasional Indonesia', 'pengarang' => 'Nugroho Notosusanto', 'penerbit' => 'Balai Pustaka', 'tahun_terbit' => '1984', 'stok' => 10],
            ['category' => 'Sejarah', 'judul' => 'Nusantara: Sejarah Indonesia', 'pengarang' => 'Bernard H.M. Vlekke', 'penerbit' => 'KPG', 'tahun_terbit' => '2008', 'stok' => 5],
            
            // Pendidikan
            ['category' => 'Pendidikan', 'judul' => 'Pedagogik Kritis', 'pengarang' => 'Henry Giroux', 'penerbit' => 'EduBooks', 'tahun_terbit' => '2019', 'stok' => 4],
            ['category' => 'Pendidikan', 'judul' => 'Psikologi Pendidikan', 'pengarang' => 'John Santrock', 'penerbit' => 'Salemba Humanika', 'tahun_terbit' => '2017', 'stok' => 6],
            ['category' => 'Pendidikan', 'judul' => 'Dasar-Dasar Ilmu Pendidik', 'pengarang' => 'Umar Tirtarahardja', 'penerbit' => 'Rineka Cipta', 'tahun_terbit' => '2015', 'stok' => 2],
            
            // Anak
            ['category' => 'Anak', 'judul' => 'Kancil dan Buaya', 'pengarang' => 'Rahim', 'penerbit' => 'Bhuana Ilmu', 'tahun_terbit' => '2010', 'stok' => 12],
            ['category' => 'Anak', 'judul' => 'Si Juki Seri Keroyokan', 'pengarang' => 'Faza Meonk', 'penerbit' => 'Bukune', 'tahun_terbit' => '2016', 'stok' => 7],
            ['category' => 'Anak', 'judul' => 'Petualangan Sherina', 'pengarang' => 'Mira Lesmana', 'penerbit' => 'Miles', 'tahun_terbit' => '2000', 'stok' => 3],
        ];

        foreach ($bukuContoh as $index => $buku) {
            Book::firstOrCreate([
                'judul' => $buku['judul']
            ], [
                'category_id' => $categories[$buku['category']]->id,
                'pengarang' => $buku['pengarang'],
                'penerbit' => $buku['penerbit'],
                'tahun_terbit' => $buku['tahun_terbit'],
                'isbn' => '978-' . rand(100000000, 999999999),
                'stok' => $buku['stok'],
                'lokasi_rak' => 'Rak ' . chr(rand(65, 70)) . '-' . rand(1, 10),
                'sinopsis' => 'Buku ' . $buku['judul'] . ' adalah sebuah mahakarya dari ' . $buku['pengarang'] . '. Buku ini membahas banyak hal menarik dan cocok untuk dibaca di waktu luang.',
                'jumlah_halaman' => rand(100, 500)
            ]);
        }
    }
}
