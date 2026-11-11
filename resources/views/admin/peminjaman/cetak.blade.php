<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku — Lentera Pustaka</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-lentera-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --hijau-tua: #162E27;
            --hijau-sedang: #275347;
            --emas: #D4A24C;
            --krem: #FDFBF6;
            --abu-garis: #CBD5E1;
            --teks-utama: #111827;
            --teks-sekunder: #4B5563;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #EDF2F0;
            color: var(--teks-utama);
            font-size: 13px;
            line-height: 1.5;
        }

        /* Toolbar Kontrol di Layar (Tidak ikut tercetak) */
        .print-toolbar {
            background: linear-gradient(135deg, #162E27 0%, #275347 100%);
            color: #FFFFFF;
            padding: 14px 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.18);
            border-bottom: 2px solid var(--emas);
        }

        .toolbar-inner {
            max-width: 1120px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .toolbar-filter-form {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .toolbar-field {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(240, 198, 116, 0.4);
            padding: 5px 10px;
            border-radius: 8px;
        }

        .toolbar-field label {
            font-size: 11.5px;
            font-weight: 600;
            color: #FCEAC1;
            white-space: nowrap;
        }

        .toolbar-field input,
        .toolbar-field select {
            background: #FFFFFF;
            color: #111827;
            border: none;
            border-radius: 5px;
            padding: 4px 8px;
            font-size: 12px;
            font-family: inherit;
        }

        .btn-toolbar {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.12);
            color: #FFFFFF;
            border-color: rgba(255, 255, 255, 0.28);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        .btn-filter {
            background: #3E7B68;
            color: #FFFFFF;
            border-color: rgba(240, 198, 116, 0.5);
        }

        .btn-filter:hover {
            background: #2F5D50;
        }

        .btn-print {
            background: linear-gradient(135deg, #F0C674 0%, #D4A24C 100%);
            color: #0D1C17;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(212, 162, 76, 0.35);
        }

        .btn-print:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #FFE29E 0%, #E2B55E 100%);
        }

        /* Lembar Kertas Laporan (Ukuran A4 Portrait) */
        .print-page {
            max-width: 840px;
            margin: 24px auto 48px;
            background: #FFFFFF;
            padding: 32px 36px;
            border-radius: 12px;
            box-shadow: 0 10px 32px rgba(15, 23, 42, 0.08);
        }

        /* Kop Surat Perpustakaan */
        .report-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 12px;
            border-bottom: 3px double var(--hijau-tua);
            margin-bottom: 16px;
        }

        .report-logo {
            width: 58px;
            height: 58px;
            border-radius: 12px;
            object-fit: cover;
            border: 1.5px solid var(--emas);
            flex-shrink: 0;
        }

        .report-institution {
            flex: 1;
        }

        .report-institution h1 {
            font-family: 'Merriweather', serif;
            font-size: 17px;
            font-weight: 900;
            color: var(--hijau-tua);
            margin: 0 0 3px 0;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .report-institution p {
            margin: 0;
            font-size: 11.5px;
            color: var(--teks-sekunder);
            line-height: 1.4;
        }

        /* Judul Laporan & Info Periode */
        .report-title-block {
            text-align: center;
            margin-bottom: 16px;
        }

        .report-title-block h2 {
            font-family: 'Merriweather', serif;
            font-size: 14.5px;
            font-weight: 700;
            margin: 0 0 5px 0;
            color: var(--teks-utama);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .report-period-badge {
            display: inline-block;
            background: #F4F7F5;
            border: 1px solid #CBD5E1;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--hijau-tua);
        }

        /* Ringkasan Statistik (Selalu 6 Kolom Sebaris di Cetak) */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
            margin-bottom: 18px;
        }

        .summary-box {
            border: 1px solid var(--abu-garis);
            border-radius: 8px;
            padding: 8px 6px;
            background: #FAFAFA;
            text-align: center;
        }

        .summary-box .summary-val {
            font-size: 14px;
            font-weight: 700;
            color: var(--hijau-tua);
            line-height: 1.2;
        }

        .summary-box .summary-lbl {
            font-size: 9.5px;
            color: var(--teks-sekunder);
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        /* Subjudul Bagian Tabel */
        .section-heading {
            font-family: 'Merriweather', serif;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--hijau-tua);
            margin: 16px 0 8px;
            padding-bottom: 5px;
            border-bottom: 1.5px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-heading span.sub-count {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: var(--teks-sekunder);
        }

        /* Tabel Laporan Cetak */
        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 11px;
        }

        table.report-table th,
        table.report-table td {
            border: 1px solid #CBD5E1;
            padding: 6px 8px;
            vertical-align: middle;
            text-align: left;
        }

        table.report-table thead th {
            background: #1F4037;
            color: #FFFFFF;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            white-space: nowrap;
        }

        table.report-table tbody tr:nth-child(even) {
            background: #F8FAFC;
        }

        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .fw-bold { font-weight: 600; }
        .text-muted-sm { font-size: 11px; color: var(--teks-sekunder); }

        /* Badge Status Cetak */
        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-dipinjam {
            background: #E0F2FE;
            color: #0369A1;
            border: 1px solid #BAE6FD;
        }

        .status-dikembalikan {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
        }

        .status-terlambat {
            background: #FEE2E2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        /* Blok Tanda Tangan */
        .signature-section {
            margin-top: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            page-break-inside: avoid;
        }

        .print-meta-note {
            font-size: 11px;
            color: var(--teks-sekunder);
        }

        .signature-box {
            width: 240px;
            text-align: center;
            font-size: 12px;
        }

        .signature-space {
            height: 64px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
            color: var(--teks-utama);
        }

        /* Aturan Khusus Media Cetak (Printer / Save as PDF — Tegak / Portrait A4) */
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            body {
                background: #FFFFFF !important;
                font-size: 11px;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
            }

            .print-page {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .summary-grid {
                grid-template-columns: repeat(6, 1fr) !important;
                gap: 6px !important;
            }

            table.report-table {
                page-break-inside: auto;
            }

            table.report-table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            table.report-table thead {
                display: table-header-group;
            }
        }

        @media screen and (max-width: 768px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .print-page {
                margin: 12px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    {{-- Toolbar Filter & Tombol Cetak (Hanya Tampil di Layar) --}}
    <div class="print-toolbar no-print">
        <div class="toolbar-inner">
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('admin.peminjaman.index') }}" class="btn-toolbar btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Kelola Peminjaman
                </a>
            </div>

            <form method="GET" action="{{ route('admin.peminjaman.cetak') }}" class="toolbar-filter-form">
                <div class="toolbar-field">
                    <label for="tanggal_mulai">Dari:</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="toolbar-field">
                    <label for="tanggal_selesai">Sampai:</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                </div>
                <div class="toolbar-field">
                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>
                <button type="submit" class="btn-toolbar btn-filter">
                    <i class="bi bi-funnel-fill"></i> Terapkan Filter
                </button>
                <button type="button" onclick="window.print()" class="btn-toolbar btn-print">
                    <i class="bi bi-printer-fill"></i> Cetak / Simpan PDF
                </button>
            </form>
        </div>
    </div>

    {{-- Lembar Laporan --}}
    <div class="print-page">
        {{-- Kop Surat Perpustakaan --}}
        <div class="report-header">
            <img src="{{ asset('images/logo-lentera-icon.png') }}" alt="Logo Lentera Pustaka" class="report-logo">
            <div class="report-institution">
                <h1>Perpustakaan Sekolah Lentera Pustaka</h1>
                <p>Jl. Laladon Baru No. 17, Ciomas, Bogor, Jawa Barat 16610 &bull; Email: lenterapustaka@gmail.com</p>
                <p>Sistem Informasi Sirkulasi Peminjaman &amp; Koleksi Buku Digital</p>
            </div>
        </div>

        {{-- Judul & Rentang Tanggal --}}
        <div class="report-title-block">
            <h2>Laporan Peminjaman &amp; Daftar Buku Terpinjam</h2>
            <div class="report-period-badge">
                Periode Tanggal Pinjam:
                @if($tanggalMulai && $tanggalSelesai)
                    {{ $tanggalMulai->translatedFormat('d F Y') }} &ndash; {{ $tanggalSelesai->translatedFormat('d F Y') }}
                @elseif($tanggalMulai)
                    Mulai {{ $tanggalMulai->translatedFormat('d F Y') }} s/d Sekarang
                @elseif($tanggalSelesai)
                    Sampai dengan {{ $tanggalSelesai->translatedFormat('d F Y') }}
                @else
                    Semua Periode
                @endif
                @if(request('status'))
                    &bull; Status: {{ ucfirst(request('status')) }}
                @endif
            </div>
        </div>

        {{-- Ringkasan Statistik --}}
        <div class="summary-grid">
            <div class="summary-box">
                <div class="summary-val">{{ number_format($ringkasan['total']) }}</div>
                <div class="summary-lbl">Total Peminjaman</div>
            </div>
            <div class="summary-box">
                <div class="summary-val">{{ number_format($ringkasan['total_judul_buku']) }}</div>
                <div class="summary-lbl">Judul Buku</div>
            </div>
            <div class="summary-box">
                <div class="summary-val">{{ number_format($ringkasan['dipinjam']) }}</div>
                <div class="summary-lbl">Sedang Dipinjam</div>
            </div>
            <div class="summary-box">
                <div class="summary-val">{{ number_format($ringkasan['dikembalikan']) }}</div>
                <div class="summary-lbl">Dikembalikan</div>
            </div>
            <div class="summary-box">
                <div class="summary-val">{{ number_format($ringkasan['terlambat']) }}</div>
                <div class="summary-lbl">Terlambat</div>
            </div>
            <div class="summary-box">
                <div class="summary-val">Rp{{ number_format($ringkasan['total_denda'], 0, ',', '.') }}</div>
                <div class="summary-lbl">Total Denda</div>
            </div>
        </div>

        {{-- BAGIAN I: Tabel Data Peminjaman --}}
        <div class="section-heading">
            <span>I. Data Transaksi Peminjaman Buku</span>
            <span class="sub-count">Total: {{ $peminjaman->count() }} transaksi</span>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 38px;">No</th>
                    <th style="width: 90px;">Tgl Pinjam</th>
                    <th>Nama Anggota &amp; NISN</th>
                    <th style="width: 85px;">Kelas</th>
                    <th>Judul Buku &amp; Pengarang</th>
                    <th style="width: 90px;">Batas Kembali</th>
                    <th style="width: 90px;">Tgl Kembali</th>
                    <th class="text-center" style="width: 95px;">Status</th>
                    <th class="text-right" style="width: 95px;">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $index => $loan)
                    @php
                        $nominalDenda = $loan->status === 'dipinjam' ? $loan->hitungDenda() : (int) $loan->denda;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>
                            <div class="fw-bold">{{ $loan->user->name ?? '-' }}</div>
                            <div class="text-muted-sm">NISN: {{ $loan->user->nis_nip ?: '-' }}</div>
                        </td>
                        <td>{{ $loan->user->kelas ?: '-' }}</td>
                        <td>
                            <div class="fw-bold">{{ $loan->book->judul ?? '-' }}</div>
                            <div class="text-muted-sm">
                                {{ $loan->book->pengarang ?? '-' }}
                                @if(!empty($loan->book?->isbn))
                                    &bull; ISBN: {{ $loan->book->isbn }}
                                @endif
                            </div>
                        </td>
                        <td>{{ $loan->batas_kembali->format('d/m/Y') }}</td>
                        <td>{{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '—' }}</td>
                        <td class="text-center">
                            @if($loan->status === 'dipinjam' && $loan->isTerlambat())
                                <span class="status-pill status-terlambat">Terlambat</span>
                            @elseif($loan->status === 'dipinjam')
                                <span class="status-pill status-dipinjam">Dipinjam</span>
                            @else
                                <span class="status-pill status-dikembalikan">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="text-right">
                            {{ $nominalDenda > 0 ? 'Rp' . number_format($nominalDenda, 0, ',', '.') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center" style="padding: 20px; color: var(--teks-sekunder);">
                            Tidak ada data transaksi peminjaman pada rentang tanggal yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- BAGIAN II: Rekap Daftar Buku yang Dipinjam --}}
        <div class="section-heading">
            <span>II. Daftar Buku yang Dipinjam pada Periode Ini</span>
            <span class="sub-count">Total: {{ $rekapBuku->count() }} judul buku</span>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 38px;">No</th>
                    <th>Judul Buku</th>
                    <th>Pengarang &amp; Penerbit</th>
                    <th style="width: 115px;">Kategori</th>
                    <th style="width: 135px;">ISBN / Rak</th>
                    <th class="text-center" style="width: 90px;">Total Dipinjam</th>
                    <th class="text-center" style="width: 95px;">Masih Dipinjam</th>
                    <th class="text-center" style="width: 95px;">Sudah Kembali</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekapBuku as $idx => $item)
                    @php($b = $item['book'])
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="fw-bold">{{ $b->judul }}</td>
                        <td>
                            <div>{{ $b->pengarang }}</div>
                            <div class="text-muted-sm">{{ $b->penerbit }} ({{ $b->tahun_terbit }})</div>
                        </td>
                        <td>{{ $b->category->nama ?? 'Umum' }}</td>
                        <td>
                            <div>{{ $b->isbn ?: '-' }}</div>
                            <div class="text-muted-sm">Rak: {{ $b->lokasi_rak ?: '-' }}</div>
                        </td>
                        <td class="text-center fw-bold">{{ $item['total_dipinjam'] }}x</td>
                        <td class="text-center">{{ $item['masih_dipinjam'] }}</td>
                        <td class="text-center">{{ $item['sudah_kembali'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 20px; color: var(--teks-sekunder);">
                            Tidak ada buku yang dipinjam pada rentang tanggal yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Tanda Tangan & Waktu Cetak --}}
        <div class="signature-section">
            <div class="print-meta-note">
                Dicetak melalui Sistem Informasi <strong>Lentera Pustaka</strong><br>
                Pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB
            </div>
            <div class="signature-box">
                <div>Bogor, {{ now()->translatedFormat('d F Y') }}</div>
                <div style="margin-top: 2px;">Petugas Administrasi Perpustakaan</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ auth()->user()->name ?? 'Admin Perpustakaan' }}</div>
                <div class="text-muted-sm">Administrator</div>
            </div>
        </div>
    </div>

    @if(request()->boolean('auto_print'))
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                window.print();
            }, 350);
        });
    </script>
    @endif
</body>
</html>

