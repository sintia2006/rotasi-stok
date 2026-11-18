
@extends('layouts.app')

@section('title', 'Barang Masuk - ROTASI STOK')
@section('heading', 'Barang Masuk')
@section('subheading', 'Catat penambahan stok barang ke dalam sistem.')

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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #2563eb;
        }

        .full {
            grid-column: 1 / -1;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        .alert {
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
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

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 25px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media(max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
@endpush

@section('content')

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="panel">
        <h2>➕ Form Tambah Barang Masuk</h2>

        <form action="{{ route('barang-masuk.store') }}" method="POST">
            @csrf

            <div class="form-grid">

                <div class="form-group full">
                    <label>Pilih Barang</label>
                    <select name="barang_id" required>
                        <option value="">-- Pilih Barang --</option>

                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}"
                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                (Stok: {{ $barang->stok }} {{ $barang->satuan }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jumlah Barang Masuk</label>
                    <input type="number"
                           name="jumlah"
                           min="1"
                           value="{{ old('jumlah') }}"
                           placeholder="Masukkan jumlah barang"
                           required>
                </div>

                <div class="form-group">
                    <label>Harga per Satuan (Rp)</label>
                    <input type="number"
                           name="harga"
                           min="0"
                           step="0.01"
                           value="{{ old('harga') }}"
                           placeholder="Contoh: 12000">
                </div>

                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', date('Y-m-d')) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text"
                           name="keterangan"
                           value="{{ old('keterangan') }}"
                           placeholder="Contoh: Pembelian dari supplier">
                </div>

                <div class="form-group full">
                    <button type="submit" class="btn-submit">
                        💾 Simpan Barang Masuk
                    </button>
                </div>

            </div>
        </form>
    </div>


    <div class="panel">
        <h2>📋 Riwayat Barang Masuk</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $transaksis->firstItem() + $index }}</td>

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
                                {{ number_format($transaksi->jumlah) }}
                                {{ $transaksi->barang->satuan ?? '' }}
                            </td>

                            <td>
                                Rp {{ number_format($transaksi->harga, 0, ',', '.') }}
                            </td>

                            <td>{{ $transaksi->keterangan ?? '-' }}</td>

                            <td>
                                <span class="badge-masuk">Barang Masuk</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada transaksi barang masuk.
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
