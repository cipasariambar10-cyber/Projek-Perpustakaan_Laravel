<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /**
     * Model Book — kerangka dasar.
     * CRUD lengkap dikerjakan oleh Nasya.
     * Hayfa menambahkan relasi loans dan helper stok.
     */

    protected $fillable = [
        'category_id',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'lokasi_rak',
        'sampul',
        'sinopsis',
        'jumlah_halaman',
    ];

    protected function casts(): array
    {
        return [
            'tahun_terbit' => 'integer',
            'stok' => 'integer',
        ];
    }

    /* ===== Relasi ===== */

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /* ===== Helper Stok (milik Hayfa) ===== */

    public function tersedia(): bool
    {
        return $this->stok > 0;
    }

    /* ===== Scopes Katalog ===== */

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function($q) use ($term) {
                $q->where('judul', 'ilike', "%{$term}%")
                  ->orWhere('pengarang', 'ilike', "%{$term}%")
                  ->orWhere('isbn', 'ilike', "%{$term}%");
            });
        }

        return $query;
    }

    /**
     * Alias scopeCari agar kompatibel jika dipanggil dengan ->cari()
     */
    public function scopeCari($query, $term)
    {
        return $this->scopeSearch($query, $term);
    }

    public function scopeKategori($query, $categoryId)
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    }

    public function scopeTersedia($query, $isTersedia)
    {
        if ($isTersedia == 'Tersedia') {
            $query->where('stok', '>', 0);
        }
    }
}
