<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Category::pluck('id', 'nama');

        $data = [
            ['Novel', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, '9789793062792', 5, 'A-01', 'Kisah sepuluh anak Belitung yang berjuang menuntut ilmu di sekolah sederhana dengan semangat dan mimpi besar.'],
            ['Novel', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Lentera Dipantara', 1980, '9789799731234', 3, 'A-02', 'Kisah Minke, pribumi terpelajar di masa kolonial Hindia Belanda.'],
            ['Novel', 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia Pustaka Utama', 2009, '9789792248616', 4, 'A-03', 'Perjalanan enam santri dengan mantra "man jadda wajada".'],
            ['Novel', 'Bumi', 'Tere Liye', 'Gramedia Pustaka Utama', 2014, '9786020332956', 6, 'A-04', 'Petualangan Raib, Seli, dan Ali di dunia paralel.'],
            ['Pelajaran', 'Matematika SMA Kelas X', 'Sukino', 'Erlangga', 2017, '9786022984011', 10, 'B-01', 'Buku pegangan Matematika kelas X sesuai kurikulum.'],
            ['Pelajaran', 'Bahasa Indonesia SMA Kelas XI', 'Tim Kemendikbud', 'Kemendikbud', 2018, '9786024271005', 8, 'B-02', 'Buku teks Bahasa Indonesia untuk kelas XI.'],
            ['Pelajaran', 'Bahasa Inggris Kelas XII', 'Tim Kemendikbud', 'Kemendikbud', 2018, '9786024271012', 8, 'B-03', 'Buku teks Bahasa Inggris untuk kelas XII.'],
            ['Sains', 'Fisika Dasar', 'Marthen Kanginan', 'Erlangga', 2016, '9786022984028', 7, 'C-01', 'Konsep dasar fisika disertai contoh soal dan pembahasan.'],
            ['Sains', 'Biologi Campbell', 'Neil A. Campbell', 'Erlangga', 2010, '9789790742345', 2, 'C-02', 'Referensi lengkap biologi tingkat lanjut.'],
            ['Sains', 'Kimia untuk SMA', 'Unggul Sudarmo', 'Erlangga', 2016, '9786022984035', 6, 'C-03', 'Materi kimia SMA dengan ilustrasi dan latihan.'],
            ['Sejarah', 'Sejarah Indonesia Modern', 'M.C. Ricklefs', 'Serambi', 2008, '9789790241121', 3, 'D-01', 'Sejarah Indonesia sejak 1200 hingga era modern.'],
            ['Sejarah', 'Soekarno: Penyambung Lidah Rakyat', 'Cindy Adams', 'Yayasan Bung Karno', 2011, '9789799731555', 2, 'D-02', 'Otobiografi Soekarno yang dituturkan kepada Cindy Adams.'],
            ['Agama', 'Fiqih Sunnah', 'Sayyid Sabiq', 'Pena Pundi Aksara', 2009, '9789791225113', 4, 'E-01', 'Pembahasan fiqih ibadah dan muamalah.'],
            ['Agama', 'Kisah Para Nabi', 'Ibnu Katsir', 'Pustaka Azzam', 2007, '9789791452021', 5, 'E-02', 'Kumpulan kisah para nabi dan rasul.'],
            ['Komik', 'Doraemon Vol. 1', 'Fujiko F. Fujio', 'Elex Media Komputindo', 2010, '9789790006211', 5, 'F-01', 'Petualangan Nobita bersama kucing robot dari masa depan.'],
            ['Komik', 'Detektif Conan Vol. 1', 'Gosho Aoyama', 'Elex Media Komputindo', 2008, '9789790006228', 4, 'F-02', 'Kisah detektif remaja yang tubuhnya mengecil.'],
            ['Biografi', 'Habibie & Ainun', 'B.J. Habibie', 'The Habibie Center', 2010, '9789791925013', 3, 'G-01', 'Kisah cinta dan perjalanan hidup B.J. Habibie bersama Ainun.'],
            ['Biografi', 'Kartini: Habis Gelap Terbitlah Terang', 'R.A. Kartini', 'Balai Pustaka', 2005, '9789794071106', 4, 'G-02', 'Kumpulan surat R.A. Kartini tentang emansipasi perempuan.'],
            ['Referensi', 'Kamus Besar Bahasa Indonesia', 'Tim Pusat Bahasa', 'Balai Pustaka', 2008, '9789794062432', 2, 'H-01', 'Kamus acuan bahasa Indonesia baku.'],
            ['Referensi', 'Atlas Dunia', 'Tim Penyusun', 'Pustaka Ilmu', 2015, '9786022871234', 3, 'H-02', 'Atlas peta dunia dan informasi geografis.'],
        ];

        foreach ($data as [$kat, $judul, $pengarang, $penerbit, $tahun, $isbn, $stok, $rak, $sinopsis]) {
            Book::updateOrCreate(
                ['isbn' => $isbn],
                [
                    'category_id' => $kategori[$kat],
                    'judul' => $judul,
                    'pengarang' => $pengarang,
                    'penerbit' => $penerbit,
                    'tahun_terbit' => $tahun,
                    'stok' => $stok,
                    'lokasi_rak' => $rak,
                    'sampul' => null,
                    'sinopsis' => $sinopsis,
                ]
            );
        }
    }
}
