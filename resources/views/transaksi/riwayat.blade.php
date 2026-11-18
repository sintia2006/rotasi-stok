
@extends('layouts.app')

@section('title', 'Riwayat Transaksi - ROTASI STOK')
@section('heading', 'Riwayat Transaksi')
@section('subheading', 'Daftar seluruh aktivitas barang masuk dan barang keluar.')

@push('styles')
    <style>
        .panel {
            background: white;
            padding: 25px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        .panel h2 {
            font-size: 19px;
            color: #172554;
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .filter-form input,
        .filter-form select {
            padding: 12px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            background: white;
        }

        .filter-form input {
            flex: 1;
            min-width: 200px;
        }

        .filter-form select {
            min-width: 160px;
        }

        .btn-search {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-reset {
            display: inline-block;
            background: #e2e8f0;
            color: #334155;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 14px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th {
            background: #eff6ff;
            color: #1e3a8a;
            padding: 14px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .badge-masuk {
            background: #dcfce7;
            color: #15803d;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-keluar {
            background: #fee2e2;
            color: #b91c1c;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 25px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media(max-width: 700px) {
            .filter-form {
                flex-direction: column;
            }

            .filter-form input,
            .filter-form select {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    <div class="panel">

        <h2>🔎 Pencarian dan Filter Transaksi</h2>

        <form action="{{ route('transaksi.riwayat') }}"
              method="GET"
              class="filter-form">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari kode barang, nama barang, atau keterangan...">

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

            <button type="submit" class="btn-search">
                🔍 Cari
            </button>

            <a href="{{ route('transaksi.riwayat') }}" class="btn-reset">
                Reset
            </a>

        </form>


        <h2>📦 Daftar Seluruh Transaksi</h2>

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Transaksi</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($transaksis as $index => $transaksi)

                        <tr>
                            <td>
                                {{ $transaksis->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $transaksi->tanggal->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $transaksi->barang->kode_barang ?? '-' }}
                            </td>

                            <td>
                                {{ $transaksi->barang->nama_barang ?? 'Barang dihapus' }}
                            </td>

                            <td>
                                @if($transaksi->jenis == 'masuk')
                                    <span class="badge-masuk">
                                        📥 Barang Masuk
                                    </span>
                                @else
                                    <span class="badge-keluar">
                                        📤 Barang Keluar
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ number_format($transaksi->jumlah) }}
                                {{ $transaksi->barang->satuan ?? '' }}
                            </td>

                            <td>
                                Rp {{ number_format($transaksi->harga, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $transaksi->keterangan ?? '-' }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada data transaksi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        <div class="pagination">
            {{ $transaksis->links() }}
        </div>

    </div>

@endsection
