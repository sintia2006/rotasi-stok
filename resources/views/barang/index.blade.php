@extends('layouts.app')

@section('title', 'Data Barang - Rotasi Stok')
@section('heading', 'Data Barang')
@section('subheading', 'Kelola seluruh data persediaan barang toko.')

@section('actions')
    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        + Tambah Barang
    </a>
@endsection

@push('styles')
    <style>
        .btn {
            display: inline-block;
            padding: 11px 17px;
            color: #fff;
            background: var(--app-primary);
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .btn:hover {
            background: var(--app-primary-dark);
        }

        /* SUMMARY */
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .summary-card {
            padding: 20px;
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: 14px;
            box-shadow: var(--app-shadow);
        }

        .summary-card p {
            margin-bottom: 10px;
            color: var(--app-muted);
            font-size: 12px;
        }

        .summary-card h2 {
            color: var(--app-heading);
            font-size: 24px;
        }

        .summary-icon {
            margin-bottom: 12px;
            font-size: 23px;
        }

        /* CONTENT */
        .content {
            padding: 25px;
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: 15px;
            box-shadow: var(--app-shadow);
        }

        .content-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .content-top h2 {
            color: var(--app-heading);
            font-size: 18px;
        }

        .search {
            display: flex;
            gap: 9px;
            margin-bottom: 20px;
        }

        .search input {
            width: 320px;
            max-width: 100%;
            padding: 11px 13px;
            color: var(--app-text);
            background: var(--app-surface);
            border: 1px solid #e0e5ef;
            border-radius: 8px;
            outline: none;
        }

        .search input:focus {
            border-color: var(--app-primary);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .table-wrapper table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        .table-wrapper th {
            padding: 14px 12px;
            color: #596780;
            font-size: 12px;
            text-align: left;
            background: #f2f4fb;
        }

        .table-wrapper td {
            padding: 14px 12px;
            border-bottom: 1px solid #edf0f5;
            font-size: 13px;
        }

        .table-wrapper tr:hover td {
            background: #fafbff;
        }

        .product {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-icon {
            display: grid;
            place-items: center;
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            font-size: 21px;
            background: #edf0ff;
            border-radius: 10px;
        }

        .product strong {
            display: block;
            font-size: 13px;
        }

        .product small {
            color: var(--app-muted);
            font-size: 11px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            color: #526fe3;
            background: #e8edff;
            border-radius: 20px;
            font-size: 11px;
        }

        .safe {
            color: #21845d;
            background: #e2f7ed;
        }

        .low {
            color: #c77a31;
            background: #fff0df;
        }

        .action {
            display: flex;
            gap: 7px;
        }

        .edit {
            padding: 7px 10px;
            color: #fff;
            background: var(--app-primary);
            border-radius: 6px;
            text-decoration: none;
            font-size: 11px;
        }

        .delete {
            padding: 7px 10px;
            color: #fff;
            background: #e35c70;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 11px;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 15px;
            color: #21845d;
            background: #e2f7ed;
            border-radius: 8px;
            font-size: 13px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 900px) {
            .summary {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .summary {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 16px;
            }

            .search {
                flex-wrap: wrap;
            }

            .search input {
                width: 100%;
            }

            .search .btn {
                flex: 1;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <!-- RINGKASAN -->
    <div class="summary">
        <div class="summary-card">
            <div class="summary-icon">📦</div>
            <p>Total Jenis Barang</p>
            <h2>{{ $barangs->total() }}</h2>
        </div>

        <div class="summary-card">
            <div class="summary-icon">📊</div>
            <p>Total Stok Ditampilkan</p>
            <h2>{{ number_format($barangs->sum('stok'), 0, ',', '.') }}</h2>
        </div>

        <div class="summary-card">
            <div class="summary-icon">⚠️</div>
            <p>Barang Menipis Ditampilkan</p>
            <h2>{{ $barangs->filter(fn($item) => $item->stok <= $item->stok_minimum)->count() }}</h2>
        </div>
    </div>

    <!-- DAFTAR BARANG -->
    <section class="content">
        <div class="content-top">
            <h2>📦 Daftar Barang</h2>
        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('barang.index') }}" method="GET" class="search">
            <input
                type="text"
                name="search"
                placeholder="Cari kode atau nama barang..."
                value="{{ request('search') }}"
            >

            <button type="submit" class="btn">Cari</button>
        </form>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barangs as $index => $item)
                        <tr>
                            <td>{{ $barangs->firstItem() + $index }}</td>

                            <td>
                                <div class="product">
                                    <div class="product-icon">
                                        @php
                                            $kategori = strtolower($item->kategori);
                                            $gambar = '📦';

                                            if (str_contains($kategori, 'sembako')) {
                                                $gambar = '🌾';
                                            } elseif (str_contains($kategori, 'minuman')) {
                                                $gambar = '🥤';
                                            } elseif (str_contains($kategori, 'makanan')) {
                                                $gambar = '🍪';
                                            } elseif (str_contains($kategori, 'alat')) {
                                                $gambar = '🧰';
                                            }
                                        @endphp

                                        {{ $gambar }}
                                    </div>

                                    <div>
                                        <strong>{{ $item->nama_barang }}</strong>
                                        <small>{{ $item->satuan }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $item->kode_barang }}</td>

                            <td>
                                <span class="badge">{{ $item->kategori }}</span>
                            </td>

                            <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>

                            <td>
                                {{ number_format($item->stok) }} {{ $item->satuan }}
                            </td>

                            <td>
                                @if($item->stok <= $item->stok_minimum)
                                    <span class="badge low">Stok Menipis</span>
                                @else
                                    <span class="badge safe">Stok Aman</span>
                                @endif
                            </td>

                            <td>
                                <div class="action">
                                    <a href="{{ route('barang.edit', $item->id) }}" class="edit">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('barang.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center;padding:30px;color:var(--app-muted);">
                                Belum ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $barangs->withQueryString()->links() }}
        </div>
    </section>
@endsection
