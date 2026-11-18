
@extends('layouts.app')

@section('title', 'Laporan - ROTASI STOK')
@section('heading', 'Laporan Stok dan Transaksi')
@section('subheading', 'Laporan persediaan dan aktivitas transaksi toko.')

@push('styles')
    <style>
        .panel {
            background: white;
            padding: 24px;
            border-radius: 14px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        .panel h2 {
            color: #172554;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            min-width: 150px;
        }

        .form-group label {
            font-size: 13px;
            color: #475569;
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            padding: 12px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: white;
        }

        .btn {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-search {
            background: #2563eb;
            color: white;
        }

        .btn-reset {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-print {
            background: #059669;
            color: white;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: white;
            padding: 22px;
            border-radius: 13px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border-left: 5px solid #2563eb;
        }

        .summary-card:nth-child(2) {
            border-left-color: #16a34a;
        }

        .summary-card:nth-child(3) {
            border-left-color: #dc2626;
        }

        .summary-card:nth-child(4) {
            border-left-color: #8b5cf6;
        }

        .summary-card p {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .summary-card h2 {
            color: #172554;
            font-size: 25px;
            overflow-wrap: anywhere;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th {
            background: #eff6ff;
            color: #1e3a8a;
            padding: 13px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .badge-masuk {
            background: #dcfce7;
            color: #15803d;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-keluar {
            background: #fee2e2;
            color: #b91c1c;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-tersedia {
            background: #dcfce7;
            color: #15803d;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #94a3b8;
        }

        .report-heading {
            display: none;
            text-align: center;
            margin-bottom: 25px;
        }

        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            padding: 20px;
        }

        @media(max-width: 700px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media print {
            body {
                background: white;
                color: black;
            }

            .app-sidebar,
            .app-topbar,
            .filter-panel,
            .no-print,
            .app-footer,
            .footer {
                display: none !important;
            }

            .app-main {
                margin: 0;
                padding: 0;
            }

            .panel,
            .summary-card {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
            }

            .report-heading {
                display: block;
            }

            .summary {
                grid-template-columns: repeat(2, 1fr);
            }

            table {
                min-width: 0;
                font-size: 10px;
            }

            th, td {
                padding: 7px;
                font-size: 10px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="report-heading">
        <h1>ROTASI STOK</h1>
        <h2>LAPORAN STOK DAN TRANSAKSI</h2>
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <div class="panel filter-panel">
        <h2>🔎 Filter Laporan</h2>

        <form action="{{ route('laporan.index') }}"
              method="GET"
              class="filter-form">

            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date"
                       name="tanggal_mulai"
                       value="{{ request('tanggal_mulai') }}">
            </div>

            <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="date"
                       name="tanggal_selesai"
                       value="{{ request('tanggal_selesai') }}">
            </div>

            <div class="form-group">
                <label>Jenis Transaksi</label>
                <select name="jenis">
                    <option value="">Semua Transaksi</option>
                    <option value="masuk"
                        {{ request('jenis') == 'masuk' ? 'selected' : '' }}>
                        Barang Masuk
                    </option>
                    <option value="keluar"
                        {{ request('jenis') == 'keluar' ? 'selected' : '' }}>
                        Barang Keluar
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-search">
                🔍 Tampilkan
            </button>

            <a href="{{ route('laporan.index') }}" class="btn btn-reset">
                Reset
            </a>

        </form>
    </div>

    <!-- RINGKASAN -->
    <div class="summary">

        <div class="summary-card">
            <p>📦 Total Jenis Barang</p>
            <h2>{{ $barangs->count() }}</h2>
        </div>

        <div class="summary-card">
            <p>📥 Total Barang Masuk</p>
            <h2>{{ number_format($totalMasuk, 0, ',', '.') }}</h2>
        </div>

        <div class="summary-card">
            <p>📤 Total Barang Keluar</p>
            <h2>{{ number_format($totalKeluar, 0, ',', '.') }}</h2>
        </div>

        <div class="summary-card">
            <p>📊 Total Sisa Stok FIFO</p>
            <h2>{{ number_format($totalStokFifo, 0, ',', '.') }}</h2>
        </div>

    </div>

    <!-- NILAI PERSEDIAAN FIFO -->
    <div class="panel">
        <h2>💰 Nilai Persediaan FIFO</h2>

        <div style="font-size:28px; font-weight:bold; color:#15803d;">
            Rp {{ number_format($totalNilaiFifo, 0, ',', '.') }}
        </div>

        <p style="color:#64748b; margin-top:8px; font-size:13px;">
            Nilai persediaan dihitung dari sisa stok setiap batch dikalikan harga beli batch.
        </p>
    </div>

    <!-- LAPORAN STOK BARANG -->
    <div class="panel">

        <h2>📦 Laporan Persediaan Barang</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barangs as $index => $barang)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori }}</td>
                            <td>{{ $barang->satuan }}</td>
                            <td>{{ number_format($barang->stok, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- LAPORAN DETAIL BATCH FIFO -->
    <div class="panel">

        <h2>🔄 Laporan Detail Batch FIFO</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Masuk</th>
                        <th>Jumlah Awal</th>
                        <th>Sisa Stok</th>
                        <th>Harga Beli</th>
                        <th>Nilai Sisa</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($fifoDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $detail->barang->kode_barang ?? '-' }}</td>

                            <td>{{ $detail->barang->nama_barang ?? '-' }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($detail->tanggal_masuk)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ number_format($detail->jumlah_masuk, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ number_format($detail->sisa_stok, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format(
                                    $detail->sisa_stok * $detail->harga_beli,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>
                                @if($detail->sisa_stok > 0)
                                    <span class="badge-tersedia">Tersedia</span>
                                @else
                                    <span class="badge-keluar">Habis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty">
                                Belum ada data batch FIFO.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- RIWAYAT TRANSAKSI -->
    <div class="panel">

        <h2>📋 Laporan Riwayat Transaksi</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $transaksi->tanggal->format('d-m-Y') }}</td>

                            <td>{{ $transaksi->barang->kode_barang ?? '-' }}</td>

                            <td>{{ $transaksi->barang->nama_barang ?? 'Barang dihapus' }}</td>

                            <td>
                                @if($transaksi->jenis == 'masuk')
                                    <span class="badge-masuk">Barang Masuk</span>
                                @else
                                    <span class="badge-keluar">Barang Keluar</span>
                                @endif
                            </td>

                            <td>
                                {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                {{ $transaksi->barang->satuan ?? '' }}
                            </td>

                            <td>
                                Rp {{ number_format($transaksi->harga, 0, ',', '.') }}
                            </td>

                            <td>{{ $transaksi->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada transaksi pada filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <div class="no-print" style="text-align:right; margin-bottom:20px;">
        <button onclick="window.print()" class="btn btn-print">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

@endsection
