<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
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
    ];

    protected function casts(): array
    {
        return [
            'tahun_terbit' => 'integer',
            'stok' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Pencarian judul / pengarang (tidak peka huruf besar-kecil).
     */
    public function scopeCari(Builder $query, ?string $kata): Builder
    {
        if (blank($kata)) {
            return $query;
        }

        $like = '%' . mb_strtolower(trim($kata)) . '%';

        return $query->where(function (Builder $q) use ($like) {
            $q->whereRaw('LOWER(judul) LIKE ?', [$like])
              ->orWhereRaw('LOWER(pengarang) LIKE ?', [$like]);
        });
    }

    public function scopeKategori(Builder $query, $categoryId): Builder
    {
        return filled($categoryId) ? $query->where('category_id', $categoryId) : $query;
    }

    public function tersedia(): bool
    {
        return $this->stok > 0;
    }
}
