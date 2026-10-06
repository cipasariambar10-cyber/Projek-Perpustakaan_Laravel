<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Novel', 'Pelajaran', 'Sains', 'Sejarah', 'Agama', 'Komik', 'Biografi', 'Referensi',
        ] as $nama) {
            Category::firstOrCreate(['nama' => $nama]);
        }
    }
}
