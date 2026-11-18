
@extends('layouts.app')

@section('title', 'Manajemen FIFO')
@section('heading', 'Manajemen FIFO')
@section('subheading', 'Pantau sisa stok berdasarkan urutan batch First In First Out.')

@push('styles')
<style>
    .fifo-wrapper {
        padding: 10px 0;
    }

    .fifo-header {
        background: linear-gradient(135deg, #e9fff5, #e8f1ff);
        padding: 25px;
        border-radius: 16px;
        margin-bottom: 22px;
        color: #285c50;
    }

    .fifo-header h2 {
        margin: 0 0 8px;
        font-size: 23px;
    }

    .fifo-header p {
        margin: 0;
        color: #55756d;
    }

    .fifo-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .fifo-card {
        background: white;
        padding: 22px;
        border-radius: 14px;
        border: 1px solid #e8edf0;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .fifo-card span {
        color: #718096;
        font-size: 14px;
    }

    .fifo-card h2 {
        color: #285c50;
        font-size: 28px;
        margin: 10px 0 0;
    }

    .fifo-panel {
        background: white;
        padding: 22px;
        border-radius: 14px;
        border: 1px solid #e8edf0;
        margin-bottom: 20px;
    }

    .fifo-panel h3 {
        margin: 0 0 18px;
        color: #334155;
    }

    .fifo-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: end;
    }

    .fifo-filter .form-group {
        flex: 1;
        min-width: 150px;
    }

    .fifo-filter label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .fifo-filter input,
    .fifo-filter select {
        width: 100%;
        padding: 10px;
        border: 1px solid #dce3e8;
        border-radius: 8px;
        background: white;
    }

    .fifo-button {
        padding: 11px 18px;
        background: #287c68;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .fifo-reset {
        background: #64748b;
    }

    .fifo-table-wrapper {
        overflow-x: auto;
    }

    .fifo-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .fifo-table th {
        background: #f1f7f5;
        color: #385e54;
        padding: 13px;
        text-align: left;
        font-size: 13px;
    }

    .fifo-table td {
        padding: 13px;
        border-bottom: 1px solid #edf0f2;
        color: #475569;
        font-size: 14px;
    }

    .fifo-table tr:hover {
        background: #f9fcfb;
    }

    .fifo-badge {
        background: #e5f7ef;
        color: #198754;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .fifo-empty {
        text-align: center;
        padding: 35px !important;
        color: #94a3b8 !important;
    }

    .fifo-pagination {
        margin-top: 18px;
    }

    @media (max-width: 600px) {
        .fifo-header {
            padding: 18px;
        }

        .fifo-panel {
            padding: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="fifo-wrapper">

    <div class="fifo-header">
        <h2>Manajemen Stok FIFO</h2>
        <p>
            First In First Out — stok yang masuk lebih dahulu
            diprioritaskan untuk dikeluarkan lebih dahulu.
        </p>
    </div>

    <div class="fifo-summary">
        <div class="fifo-card">
            <span>Total Sisa Stok FIFO</span>
            <h2>{{ number_format($totalSisa, 0, ',', '.') }}</h2>
        </div>

        <div class="fifo-card">
            <span>Total Data Batch</span>
            <h2>{{ $details->total() }}</h2>
        </div>
    </div>

    <div class="fifo-panel">
        <h3>Filter Data Stok</h3>

        <form action="{{ route('fifo.index') }}" method="GET">
            <div class="fifo-filter">

                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="barang_id">
                        <option value="">Semua Barang</option>

                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}"
                                {{ request('barang_id') == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Awal</label>
                    <input type="date" name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}">
                </div>

                <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}">
                </div>

                <button type="submit" class="fifo-button">
                    Cari Data
                </button>

                <a href="{{ route('fifo.index') }}"
                    class="fifo-button fifo-reset">
                    Reset
                </a>

            </div>
        </form>
    </div>

    <div class="fifo-panel">
        <h3>Daftar Stok Masuk Berdasarkan FIFO</h3>

        <div class="fifo-table-wrapper">
            <table class="fifo-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Masuk</th>
                        <th>Jumlah Masuk</th>
                        <th>Sisa Stok</th>
                        <th>Harga Beli</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($details as $index => $detail)
                        <tr>
                            <td>{{ $details->firstItem() + $index }}</td>

                            <td>
                                {{ $detail->barang->kode_barang ?? '-' }}
                            </td>

                            <td>
                                {{ $detail->barang->nama_barang ?? '-' }}
                            </td>

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
                                @if($detail->sisa_stok > 0)
                                    <span class="fifo-badge">Tersedia</span>
                                @else
                                    <span class="fifo-badge"
                                        style="background:#fee2e2;color:#b91c1c;">
                                        Habis
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="fifo-empty">
                                Belum ada data stok FIFO.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="fifo-pagination">
            {{ $details->links() }}
        </div>
    </div>

</div>

@endsection
