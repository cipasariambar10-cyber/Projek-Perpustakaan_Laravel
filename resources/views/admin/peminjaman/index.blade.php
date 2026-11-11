@extends('layouts.admin')

@section('title', 'Kelola Peminjaman — Perpustakaan')

@section('content')
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h1 class="page-title">Peminjaman</h1>
                    <p class="page-subtitle mb-0">Kelola peminjaman dan pengembalian buku</p>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button" class="btn btn-hijau" data-bs-toggle="modal" data-bs-target="#modalCetakLaporan">
                        <i class="bi bi-printer me-2"></i> Cetak Laporan
                    </button>
                    <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-emas">
                        <i class="bi bi-plus-circle me-2"></i> Catat Peminjaman
                    </a>
                </div>
            </div>

            {{-- Kartu Statistik Peminjaman --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-green" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem;">{{ number_format($stats['total']) }}</div>
                        <div class="stat-label">Total Transaksi</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-blue" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem; color: var(--status-dipinjam);">{{ number_format($stats['dipinjam']) }}</div>
                        <div class="stat-label">Sedang Dipinjam</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-gold" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem; color: var(--status-dikembalikan);">{{ number_format($stats['dikembalikan']) }}</div>
                        <div class="stat-label">Dikembalikan</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-red" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem; color: var(--status-terlambat);">{{ number_format($stats['terlambat']) }}</div>
                        <div class="stat-label">Terlambat</div>
                    </div>
                </div>
            </div>

            {{-- Filter & Pencarian --}}
            <div class="card-perpus mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="row g-3 align-items-end form-perpus">
                        <div class="col-md-5">
                            <label class="form-label"><i class="bi bi-search me-1"></i> Pencarian</label>
                            <input type="text" name="cari" class="form-control" placeholder="Nama anggota, NISN, atau judul buku..." value="{{ request('cari') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><i class="bi bi-funnel me-1"></i> Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-hijau flex-fill">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            @if(request()->hasAny(['cari', 'status']))
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-hijau">
                                <i class="bi bi-x-lg"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Peminjaman --}}
            <div class="card-perpus">
                <div class="card-body p-0">
                    @if($peminjaman->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-perpus mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Tgl Kembali</th>
                                    <th>Denda</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman as $i => $loan)
                                <tr>
                                    <td>{{ $peminjaman->firstItem() + $i }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                                 style="width:32px;height:32px;background:var(--gradient-green);color:var(--cream-50);font-size:0.75rem;font-weight:600;flex-shrink:0;box-shadow:var(--shadow-sm);">
                                                {{ strtoupper(substr($loan->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="font-size:0.88rem;">{{ $loan->user->name ?? '-' }}</div>
                                                <div style="font-size:0.75rem; color: var(--teks-lembut);">{{ $loan->user->nis_nip ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if(!empty($loan->book?->sampul))
                                                <img src="{{ asset('storage/' . $loan->book->sampul) }}"
                                                     alt="Cover"
                                                     class="rounded shadow-sm flex-shrink-0"
                                                     style="width: 34px; height: 48px; object-fit: cover; object-position: center top; border: 1px solid var(--cream-200);">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center rounded text-center flex-shrink-0"
                                                     style="width: 34px; height: 48px; background: var(--gradient-green); color: var(--cream-50); font-size: 0.8rem;">
                                                    <i class="bi bi-book"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold" style="font-size:0.88rem;">{{ $loan->book->judul ?? '-' }}</div>
                                                <div style="font-size:0.75rem; color: var(--teks-lembut);">{{ $loan->book->pengarang ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="white-space:nowrap;">{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td style="white-space:nowrap;">{{ $loan->batas_kembali->format('d/m/Y') }}</td>
                                    <td style="white-space:nowrap;">
                                        {{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '—' }}
                                    </td>
                                    <td>
                                        @if($loan->denda > 0 || ($loan->status === 'dipinjam' && $loan->isTerlambat()))
                                            <span style="color: var(--status-terlambat); font-weight: 600;">
                                                Rp{{ number_format($loan->status === 'dipinjam' ? $loan->hitungDenda() : $loan->denda, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span style="color: var(--teks-muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($loan->status === 'dipinjam' && $loan->isTerlambat())
                                            <span class="badge badge-status badge-terlambat">
                                                <i class="bi bi-exclamation-triangle me-1"></i> Terlambat
                                            </span>
                                        @elseif($loan->status === 'dipinjam')
                                            <span class="badge badge-status badge-dipinjam">Dipinjam</span>
                                        @else
                                            <span class="badge badge-status badge-dikembalikan">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.peminjaman.show', $loan) }}" class="btn btn-sm btn-outline-hijau" title="Detail" style="padding:0.25rem 0.5rem; font-size:0.78rem;">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            @if($loan->status === 'dipinjam')
                                            <form method="POST" action="{{ route('admin.peminjaman.kembalikan', $loan) }}" class="d-inline"
                                                  onsubmit="return confirm('Konfirmasi pengembalian buku?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-emas" title="Kembalikan" style="padding:0.25rem 0.5rem; font-size:0.78rem;">
                                                    <i class="bi bi-box-arrow-in-down"></i>
                                                </button>
                                            </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.peminjaman.destroy', $loan) }}" class="d-inline"
                                                  onsubmit="return confirm('Yakin hapus data peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" style="padding:0.25rem 0.5rem; font-size:0.78rem;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="table-pagination-footer">
                        <div class="pagination-info-text">
                            Menampilkan <strong>{{ $peminjaman->firstItem() }}–{{ $peminjaman->lastItem() }}</strong> dari <strong>{{ $peminjaman->total() }}</strong> data peminjaman
                        </div>
                        {{ $peminjaman->links() }}
                    </div>

                    @else
                    <div class="empty-state py-5">
                        <i class="bi bi-arrow-left-right" style="font-size:3rem;"></i>
                        <p class="mb-1 fw-semibold">Belum ada data peminjaman</p>
                        <p class="mb-3" style="font-size:0.85rem;">Mulai catat peminjaman buku baru.</p>
                        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-hijau btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Catat Peminjaman
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Modal Filter Rentang Tanggal Cetak Laporan Peminjaman --}}
            <div class="modal fade" id="modalCetakLaporan" tabindex="-1" aria-labelledby="modalCetakLaporanLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modal-perpus">
                        <div class="modal-header modal-header-perpus">
                            <div class="d-flex align-items-center gap-2">
                                <span class="modal-icon-badge">
                                    <i class="bi bi-printer-fill"></i>
                                </span>
                                <div>
                                    <h5 class="modal-title mb-0" id="modalCetakLaporanLabel">Cetak Laporan Peminjaman</h5>
                                    <small class="modal-subtitle">Pilih rentang tanggal transaksi peminjaman buku</small>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <form method="GET" action="{{ route('admin.peminjaman.cetak') }}" target="_blank" class="form-perpus" id="formCetakLaporan">
                            <input type="hidden" name="auto_print" value="1">
                            <div class="modal-body p-4">
                                {{-- Pilihan Cepat Rentang Tanggal --}}
                                <div class="mb-3">
                                    <label class="form-label d-block mb-2" style="font-size: 0.8rem;">
                                        <i class="bi bi-lightning-charge me-1" style="color: var(--gold-500);"></i> Pilihan Cepat Periode
                                    </label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-hijau rounded-pill px-3" onclick="setRentangCetak('hari_ini')">Hari Ini</button>
                                        <button type="button" class="btn btn-sm btn-outline-hijau rounded-pill px-3" onclick="setRentangCetak('7_hari')">7 Hari Terakhir</button>
                                        <button type="button" class="btn btn-sm btn-outline-hijau rounded-pill px-3" onclick="setRentangCetak('bulan_ini')">Bulan Ini</button>
                                        <button type="button" class="btn btn-sm btn-outline-hijau rounded-pill px-3" onclick="setRentangCetak('semua')">Semua Periode</button>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label for="cetak_tanggal_mulai" class="form-label">
                                            <i class="bi bi-calendar-plus me-1"></i> Dari Tanggal
                                        </label>
                                        <input type="date" id="cetak_tanggal_mulai" name="tanggal_mulai"
                                               class="form-control"
                                               value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="cetak_tanggal_selesai" class="form-label">
                                            <i class="bi bi-calendar-check me-1"></i> Sampai Tanggal
                                        </label>
                                        <input type="date" id="cetak_tanggal_selesai" name="tanggal_selesai"
                                               class="form-control"
                                               value="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="cetak_status" class="form-label">
                                        <i class="bi bi-funnel me-1"></i> Filter Status Peminjaman
                                    </label>
                                    <select id="cetak_status" name="status" class="form-select">
                                        <option value="">Semua Status (Dipinjam, Dikembalikan & Terlambat)</option>
                                        <option value="dipinjam">Sedang Dipinjam</option>
                                        <option value="dikembalikan">Sudah Dikembalikan</option>
                                        <option value="terlambat">Terlambat</option>
                                    </select>
                                    <div class="form-text mt-2">
                                        <i class="bi bi-info-circle me-1"></i> Kosongkan tanggal jika ingin mencetak seluruh riwayat dari awal hingga sekarang.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer modal-footer-perpus">
                                <button type="button" class="btn btn-outline-hijau" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-emas">
                                    <i class="bi bi-printer me-1"></i> Tampilkan & Cetak Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
<script>
function setRentangCetak(tipe) {
    const inputMulai = document.getElementById('cetak_tanggal_mulai');
    const inputSelesai = document.getElementById('cetak_tanggal_selesai');
    const today = new Date();
    const formatYmd = (d) => {
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${y}-${m}-${day}`;
    };

    if (tipe === 'hari_ini') {
        const str = formatYmd(today);
        inputMulai.value = str;
        inputSelesai.value = str;
    } else if (tipe === '7_hari') {
        const past = new Date(today);
        past.setDate(today.getDate() - 6);
        inputMulai.value = formatYmd(past);
        inputSelesai.value = formatYmd(today);
    } else if (tipe === 'bulan_ini') {
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        inputMulai.value = formatYmd(firstDay);
        inputSelesai.value = formatYmd(today);
    } else if (tipe === 'semua') {
        inputMulai.value = '';
        inputSelesai.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const inputMulai = document.getElementById('cetak_tanggal_mulai');
    const inputSelesai = document.getElementById('cetak_tanggal_selesai');
    if (inputMulai && inputSelesai) {
        inputMulai.addEventListener('change', function () {
            if (inputMulai.value && inputSelesai.value && inputSelesai.value < inputMulai.value) {
                inputSelesai.value = inputMulai.value;
            }
            inputSelesai.min = inputMulai.value || '';
        });
    }
});
</script>
@endpush
