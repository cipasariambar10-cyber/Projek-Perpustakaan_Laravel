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
        $kategoriList = ['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Pendidikan', 'Anak', 'Mata Pelajaran', 'Agama', 'Sastra'];
        $categories = [];

        foreach ($kategoriList as $kat) {
            $categories[$kat] = Category::firstOrCreate([
                'nama' => $kat,
                'slug' => Str::slug($kat)
            ]);
        }

        $bukuContoh = [
            // Fiksi & Novel
            ['category' => 'Fiksi', 'judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun_terbit' => '1980', 'stok' => 5, 'sampul' => 'covers/bumi-manusia.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => '2005', 'stok' => 3, 'sampul' => 'covers/laskar-pelangi.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Cantik Itu Luka', 'pengarang' => 'Eka Kurniawan', 'penerbit' => 'Gramedia', 'tahun_terbit' => '2002', 'stok' => 0, 'sampul' => 'covers/cantik-itu-luka.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Pulang', 'pengarang' => 'Leila S. Chudori', 'penerbit' => 'KPG', 'tahun_terbit' => '2012', 'stok' => 4, 'sampul' => 'covers/pulang.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Laut Bercerita', 'pengarang' => 'Leila S. Chudori', 'penerbit' => 'KPG', 'tahun_terbit' => '2017', 'stok' => 7, 'sampul' => 'covers/laut-bercerita.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Gadis Kretek', 'pengarang' => 'Ratih Kumala', 'penerbit' => 'Gramedia', 'tahun_terbit' => '2012', 'stok' => 6, 'sampul' => 'covers/gadis-kretek.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh', 'pengarang' => 'Dee Lestari', 'penerbit' => 'Truedee', 'tahun_terbit' => '2001', 'stok' => 5, 'sampul' => 'covers/supernova-ksatria-puteri-dan-bintang-jatuh.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Aroma Karsa', 'pengarang' => 'Dee Lestari', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => '2018', 'stok' => 8, 'sampul' => 'covers/aroma-karsa.jpg'],
            ['category' => 'Fiksi', 'judul' => 'Ronggeng Dukuh Paruk', 'pengarang' => 'Ahmad Tohari', 'penerbit' => 'Gramedia', 'tahun_terbit' => '1982', 'stok' => 3, 'sampul' => 'covers/ronggeng-dukuh-paruk.jpg'],
            
            // Mata Pelajaran
            ['category' => 'Mata Pelajaran', 'judul' => 'Buku Siswa Matematika Kelas XII', 'pengarang' => 'Kemdikbud', 'penerbit' => 'Pusat Kurikulum dan Perbukuan', 'tahun_terbit' => '2018', 'stok' => 30],
            ['category' => 'Mata Pelajaran', 'judul' => 'Buku Siswa Bahasa Indonesia Kelas XI', 'pengarang' => 'Kemdikbud', 'penerbit' => 'Pusat Kurikulum dan Perbukuan', 'tahun_terbit' => '2017', 'stok' => 25],
            ['category' => 'Mata Pelajaran', 'judul' => 'Buku Siswa Bahasa Inggris Kelas X', 'pengarang' => 'Kemdikbud', 'penerbit' => 'Pusat Kurikulum dan Perbukuan', 'tahun_terbit' => '2016', 'stok' => 20],
            ['category' => 'Mata Pelajaran', 'judul' => 'Buku Siswa Fisika Kelas XII', 'pengarang' => 'Marthen Kanginan', 'penerbit' => 'Erlangga', 'tahun_terbit' => '2019', 'stok' => 15],
            ['category' => 'Mata Pelajaran', 'judul' => 'Buku Siswa Biologi Kelas XI', 'pengarang' => 'Irnaningtyas', 'penerbit' => 'Erlangga', 'tahun_terbit' => '2018', 'stok' => 18],
            ['category' => 'Mata Pelajaran', 'judul' => 'Buku Siswa Sejarah Indonesia Kelas X', 'pengarang' => 'Ratna Hapsari', 'penerbit' => 'Erlangga', 'tahun_terbit' => '2017', 'stok' => 22],
            ['category' => 'Mata Pelajaran', 'judul' => 'Buku Siswa Pendidikan Agama Islam Kelas XII', 'pengarang' => 'Kemdikbud', 'penerbit' => 'Pusat Kurikulum', 'tahun_terbit' => '2019', 'stok' => 25],
            
            // Non-Fiksi
            ['category' => 'Non-Fiksi', 'judul' => 'Filosofi Teras', 'pengarang' => 'Henry Manampiring', 'penerbit' => 'Kompas', 'tahun_terbit' => '2018', 'stok' => 10, 'sampul' => 'covers/filosofi-teras.jpg'],
            ['category' => 'Non-Fiksi', 'judul' => 'Sebuah Seni untuk Bersikap Bodo Amat', 'pengarang' => 'Mark Manson', 'penerbit' => 'Grasindo', 'tahun_terbit' => '2016', 'stok' => 2, 'sampul' => 'covers/sebuah-seni-untuk-bersikap-bodo-amat.jpg'],
            ['category' => 'Non-Fiksi', 'judul' => 'Sapiens: Riwayat Singkat Umat Manusia', 'pengarang' => 'Yuval Noah Harari', 'penerbit' => 'KPG', 'tahun_terbit' => '2011', 'stok' => 5, 'sampul' => 'covers/sapiens.jpg'],
            ['category' => 'Non-Fiksi', 'judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'penerbit' => 'Gramedia', 'tahun_terbit' => '2018', 'stok' => 8, 'sampul' => 'covers/atomic-habits.jpg'],
            ['category' => 'Non-Fiksi', 'judul' => 'Bicara Itu Ada Seninya', 'pengarang' => 'Oh Su Hyang', 'penerbit' => 'Bhuana Ilmu Populer', 'tahun_terbit' => '2018', 'stok' => 9, 'sampul' => 'covers/bicara-itu-ada-seninya.jpg'],
            
            // Sains & Teknologi
            ['category' => 'Sains', 'judul' => 'Kosmos', 'pengarang' => 'Carl Sagan', 'penerbit' => 'KPG', 'tahun_terbit' => '1980', 'stok' => 4, 'sampul' => 'covers/kosmos.jpg'],
            ['category' => 'Sains', 'judul' => 'Asal Usul Spesies', 'pengarang' => 'Charles Darwin', 'penerbit' => 'Indoliterasi', 'tahun_terbit' => '1859', 'stok' => 2, 'sampul' => 'covers/asal-usul-spesies.jpg'],
            ['category' => 'Teknologi', 'judul' => 'Belajar Coding untuk Pemula', 'pengarang' => 'Budi Raharjo', 'penerbit' => 'Informatika', 'tahun_terbit' => '2020', 'stok' => 15],
            ['category' => 'Teknologi', 'judul' => 'Mastering Laravel', 'pengarang' => 'Taylor Otwell', 'penerbit' => 'O\'Reilly', 'tahun_terbit' => '2023', 'stok' => 6, 'sampul' => 'covers/mastering-laravel.jpg'],
            ['category' => 'Teknologi', 'judul' => 'Mengenal Artificial Intelligence', 'pengarang' => 'John McCarthy', 'penerbit' => 'Tech Press', 'tahun_terbit' => '2021', 'stok' => 3, 'sampul' => 'covers/mengenal-artificial-intelligence.jpg'],
            ['category' => 'Teknologi', 'judul' => 'Pemrograman Web dengan PHP dan MySQL', 'pengarang' => 'Abdul Kadir', 'penerbit' => 'Andi Publisher', 'tahun_terbit' => '2019', 'stok' => 12, 'sampul' => 'covers/pemrograman-web-dengan-php-dan-mysql.jpg'],
            
            // Sejarah
            ['category' => 'Sejarah', 'judul' => 'Sejarah Nasional Indonesia', 'pengarang' => 'Nugroho Notosusanto', 'penerbit' => 'Balai Pustaka', 'tahun_terbit' => '1984', 'stok' => 10, 'sampul' => 'covers/sejarah-nasional-indonesia.jpg'],
            ['category' => 'Sejarah', 'judul' => 'Nusantara: Sejarah Indonesia', 'pengarang' => 'Bernard H.M. Vlekke', 'penerbit' => 'KPG', 'tahun_terbit' => '2008', 'stok' => 5, 'sampul' => 'covers/nusantara-sejarah-indonesia.jpg'],
            ['category' => 'Sejarah', 'judul' => 'Guns, Germs, and Steel', 'pengarang' => 'Jared Diamond', 'penerbit' => 'KPG', 'tahun_terbit' => '1997', 'stok' => 4, 'sampul' => 'covers/guns-germs-and-steel.jpg'],
            
            // Pendidikan
            ['category' => 'Pendidikan', 'judul' => 'Pedagogik Kritis', 'pengarang' => 'Henry Giroux', 'penerbit' => 'EduBooks', 'tahun_terbit' => '2019', 'stok' => 4],
            ['category' => 'Pendidikan', 'judul' => 'Psikologi Pendidikan', 'pengarang' => 'John Santrock', 'penerbit' => 'Salemba Humanika', 'tahun_terbit' => '2017', 'stok' => 6],
            ['category' => 'Pendidikan', 'judul' => 'Dasar-Dasar Ilmu Pendidik', 'pengarang' => 'Umar Tirtarahardja', 'penerbit' => 'Rineka Cipta', 'tahun_terbit' => '2015', 'stok' => 2],
            
            // Anak
            ['category' => 'Anak', 'judul' => 'Kancil dan Buaya', 'pengarang' => 'Rahim', 'penerbit' => 'Bhuana Ilmu', 'tahun_terbit' => '2010', 'stok' => 12, 'sampul' => 'covers/kancil-dan-buaya.jpg'],
            ['category' => 'Anak', 'judul' => 'Si Juki Seri Keroyokan', 'pengarang' => 'Faza Meonk', 'penerbit' => 'Bukune', 'tahun_terbit' => '2016', 'stok' => 7, 'sampul' => 'covers/si-juki-seri-keroyokan.jpg'],
            ['category' => 'Anak', 'judul' => 'Petualangan Sherina', 'pengarang' => 'Mira Lesmana', 'penerbit' => 'Miles', 'tahun_terbit' => '2000', 'stok' => 3, 'sampul' => 'covers/petualangan-sherina.jpg'],
            ['category' => 'Anak', 'judul' => 'Kumpulan Dongeng Nusantara', 'pengarang' => 'MB. Rahimsyah', 'penerbit' => 'Lingkar Media', 'tahun_terbit' => '2015', 'stok' => 10, 'sampul' => 'covers/kumpulan-dongeng-nusantara.jpg'],
            
            // Agama
            ['category' => 'Agama', 'judul' => 'Tafsir Al-Misbah', 'pengarang' => 'M. Quraish Shihab', 'penerbit' => 'Lentera Hati', 'tahun_terbit' => '2000', 'stok' => 5, 'sampul' => 'covers/tafsir-al-misbah.jpg'],
            ['category' => 'Agama', 'judul' => 'Fikih Sunnah', 'pengarang' => 'Sayyid Sabiq', 'penerbit' => 'Pena Pundi Aksara', 'tahun_terbit' => '2013', 'stok' => 8, 'sampul' => 'covers/fikih-sunnah.jpg'],
            
            // Sastra
            ['category' => 'Sastra', 'judul' => 'Hujan Bulan Juni', 'pengarang' => 'Sapardi Djoko Damono', 'penerbit' => 'Gramedia', 'tahun_terbit' => '1994', 'stok' => 7, 'sampul' => 'covers/hujan-bulan-juni.jpg'],
            ['category' => 'Sastra', 'judul' => 'Aku Ini Binatang Jalang', 'pengarang' => 'Chairil Anwar', 'penerbit' => 'Gramedia', 'tahun_terbit' => '1986', 'stok' => 5, 'sampul' => 'covers/aku-ini-binatang-jalang.jpg'],
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
                'sampul' => $buku['sampul'] ?? null,
                'sinopsis' => 'Buku ' . $buku['judul'] . ' adalah sebuah mahakarya dari ' . $buku['pengarang'] . '. Buku ini sangat cocok dibaca untuk menambah wawasan.',
                'jumlah_halaman' => rand(100, 500)
            ]);
        }
    }
}
