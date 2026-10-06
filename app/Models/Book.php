<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /* ===== Relasi ===== */

    /**
     * Relasi ke peminjaman (milik Hayfa).
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Relasi ke kategori (milik Nasya).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /* ===== Helper Stok (milik Hayfa) ===== */

    /**
     * Apakah buku masih tersedia untuk dipinjam?
     */
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
