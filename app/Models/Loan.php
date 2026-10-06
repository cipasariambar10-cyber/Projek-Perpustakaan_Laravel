<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Loan extends Model
{
    /**
     * Model Loan — milik Hayfa.
     * Mengelola data peminjaman buku.
     */

    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'batas_kembali',
        'tanggal_kembali',
        'denda',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'  => 'date',
            'batas_kembali'   => 'date',
            'tanggal_kembali' => 'date',
            'denda'           => 'integer',
        ];
    }

    /* ===== Relasi ===== */

    /**
     * Peminjam (anggota).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Buku yang dipinjam.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /* ===== Helper ===== */

    /**
     * Apakah peminjaman ini sudah melewati batas kembali?
     */
    public function isTerlambat(): bool
    {
        if ($this->status === 'dikembalikan') {
            // Terlambat jika dikembalikan setelah batas
            return $this->tanggal_kembali && $this->tanggal_kembali->greaterThan($this->batas_kembali);
        }

        // Masih dipinjam, cek apakah hari ini sudah melewati batas
        return Carbon::today()->greaterThan($this->batas_kembali);
    }

    /**
     * Hitung jumlah hari keterlambatan.
     */
    public function hariTerlambat(): int
    {
        if ($this->status === 'dikembalikan' && $this->tanggal_kembali) {
            $selisih = $this->tanggal_kembali->diffInDays($this->batas_kembali, false);
            return $selisih < 0 ? abs($selisih) : 0;
        }

        // Masih dipinjam
        $selisih = Carbon::today()->diffInDays($this->batas_kembali, false);
        return $selisih < 0 ? abs($selisih) : 0;
    }

    /**
     * Hitung denda keterlambatan.
     * Rp1.000 per hari terlambat.
     */
    public function hitungDenda(): int
    {
        return $this->hariTerlambat() * 1000;
    }

    /* ===== Scope ===== */

    /**
     * Scope: hanya yang statusnya dipinjam.
     */
    public function scopeDipinjam($query)
    {
        return $query->where('status', 'dipinjam');
    }

    /**
     * Scope: hanya yang sudah dikembalikan.
     */
    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    /**
     * Scope: yang terlambat (dipinjam & melewati batas).
     */
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'dipinjam')
                     ->where('batas_kembali', '<', Carbon::today());
    }
}
