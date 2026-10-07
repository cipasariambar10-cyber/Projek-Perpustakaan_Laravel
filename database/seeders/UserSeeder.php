<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed data admin dan anggota contoh.
     */
    public function run(): void
    {
        // ===== ADMIN =====
        User::updateOrCreate(
            ['email' => 'adminperpustakaan@gmail.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nis_nip' => '198501012010011001',
                'kelas' => null,
                'no_hp' => '081234567890',
                'status' => 'aktif',
            ]
        );

        // ===== ANGGOTA CONTOH =====
        $anggota = [
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'nis_nip' => '12001',
                'kelas' => 'XII IPA 1',
                'no_hp' => '081234567891',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@gmail.com',
                'nis_nip' => '12002',
                'kelas' => 'XII IPA 2',
                'no_hp' => '081234567892',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'nis_nip' => '11001',
                'kelas' => 'XI IPS 1',
                'no_hp' => '081234567893',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'nis_nip' => '11002',
                'kelas' => 'XI IPA 1',
                'no_hp' => '081234567894',
            ],
            [
                'name' => 'Rina Marlina',
                'email' => 'rina@gmail.com',
                'nis_nip' => '10001',
                'kelas' => 'X IPA 1',
                'no_hp' => '081234567895',
            ],
            [
                'name' => 'Dimas Pratama',
                'email' => 'dimas@gmail.com',
                'nis_nip' => '10002',
                'kelas' => 'X IPS 1',
                'no_hp' => '081234567896',
            ],
            [
                'name' => 'Anisa Rahma',
                'email' => 'anisa@gmail.com',
                'nis_nip' => '12003',
                'kelas' => 'XII IPS 1',
                'no_hp' => '081234567897',
            ],
            [
                'name' => 'Yoga Firmansyah',
                'email' => 'yoga@gmail.com',
                'nis_nip' => '11003',
                'kelas' => 'XI IPA 2',
                'no_hp' => '081234567898',
            ],
        ];

        foreach ($anggota as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('siswa123'),
                    'role' => 'anggota',
                    'status' => 'aktif',
                ])
            );
        }

        // Satu anggota nonaktif untuk testing
        User::updateOrCreate(
            ['email' => 'nonaktif@gmail.com'],
            [
                'name' => 'Pengguna Nonaktif',
                'password' => Hash::make('siswa123'),
                'role' => 'anggota',
                'nis_nip' => '99999',
                'kelas' => 'Alumni',
                'no_hp' => '081234567899',
                'status' => 'nonaktif',
            ]
        );
    }
}
