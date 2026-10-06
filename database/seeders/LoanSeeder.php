<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Seeder data contoh peminjaman — milik Hayfa.
     * Jalankan setelah UserSeeder dan seeder buku (milik Nasya).
     */
    public function run(): void
    {
        // Ambil anggota dan buku yang tersedia
        $anggota = User::where('role', 'anggota')->get();
        $buku = Book::where('stok', '>', 0)->get();

        if ($anggota->isEmpty() || $buku->isEmpty()) {
            $this->command->info('LoanSeeder: Tidak ada anggota atau buku. Lewati seeder peminjaman.');
            return;
        }

        $now = Carbon::today();

        // Data contoh peminjaman
        $loans = [
            // 1. Peminjaman aktif — belum dikembalikan, belum terlambat
            [
                'user_id'        => $anggota->get(0)?->id,
                'book_id'        => $buku->get(0)?->id,
                'tanggal_pinjam' => $now->copy()->subDays(3),
                'batas_kembali'  => $now->copy()->addDays(4),
                'status'         => 'dipinjam',
            ],
            // 2. Peminjaman aktif — sudah terlambat 3 hari
            [
                'user_id'        => $anggota->get(1)?->id ?? $anggota->get(0)?->id,
                'book_id'        => $buku->get(1)?->id ?? $buku->get(0)?->id,
                'tanggal_pinjam' => $now->copy()->subDays(10),
                'batas_kembali'  => $now->copy()->subDays(3),
                'status'         => 'dipinjam',
            ],
            // 3. Sudah dikembalikan tepat waktu
            [
                'user_id'        => $anggota->get(2)?->id ?? $anggota->get(0)?->id,
                'book_id'        => $buku->get(2)?->id ?? $buku->get(0)?->id,
                'tanggal_pinjam' => $now->copy()->subDays(14),
                'batas_kembali'  => $now->copy()->subDays(7),
                'tanggal_kembali'=> $now->copy()->subDays(8),
                'denda'          => 0,
                'status'         => 'dikembalikan',
            ],
            // 4. Dikembalikan terlambat 2 hari (denda Rp2.000)
            [
                'user_id'        => $anggota->get(0)?->id,
                'book_id'        => $buku->get(3)?->id ?? $buku->get(0)?->id,
                'tanggal_pinjam' => $now->copy()->subDays(12),
                'batas_kembali'  => $now->copy()->subDays(5),
                'tanggal_kembali'=> $now->copy()->subDays(3),
                'denda'          => 2000,
                'status'         => 'dikembalikan',
            ],
            // 5. Peminjaman aktif — baru pinjam hari ini
            [
                'user_id'        => $anggota->get(3)?->id ?? $anggota->get(1)?->id ?? $anggota->get(0)?->id,
                'book_id'        => $buku->get(4)?->id ?? $buku->get(0)?->id,
                'tanggal_pinjam' => $now->copy(),
                'batas_kembali'  => $now->copy()->addDays(7),
                'status'         => 'dipinjam',
            ],
        ];

        foreach ($loans as $data) {
            if (!$data['user_id'] || !$data['book_id']) {
                continue;
            }

            // Cek stok sebelum membuat peminjaman
            $book = Book::find($data['book_id']);
            if (!$book || $book->stok <= 0) {
                continue;
            }

            Loan::create($data);

            // Kurangi stok buku jika masih dipinjam
            if ($data['status'] === 'dipinjam') {
                $book->decrement('stok');
            }
        }

        $this->command->info('LoanSeeder: ' . Loan::count() . ' data peminjaman berhasil dibuat.');
    }
}
