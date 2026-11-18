@extends('layouts.app')

@section('title', 'Edit Barang')
@section('heading', 'Edit Barang')
@section('subheading', 'Perbarui informasi data barang.')

@push('styles')
    <style>
        .form-container {
            max-width: 700px;
        }

        .form-container h3 {
            color: var(--app-heading);
            font-size: 17px;
        }

        .form-container > p {
            margin-top: 6px;
            color: var(--app-muted);
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: var(--app-heading);
            font-size: 13px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px 12px;
            color: var(--app-text);
            background: var(--app-surface);
            border: 1px solid #dce3ec;
            border-radius: 8px;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 3px rgba(36, 120, 220, .1);
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-save {
            color: #fff;
            background: var(--app-primary);
        }

        .btn-save:hover {
            background: var(--app-primary-dark);
        }

        .btn-back {
            color: #39465a;
            background: #e9edf3;
        }

        .error {
            margin-top: 5px;
            color: var(--app-danger);
            font-size: 13px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            flex-wrap: wrap;
        }
    </style>
@endpush

@section('content')
    <div class="panel form-container">
        <h3>Form Edit Barang</h3>
        <p>Silakan ubah informasi barang di bawah ini.</p>

        <form action="{{ route('barang.update', $barang->id) }}"
              method="POST"
              style="margin-top: 22px;">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" id="kode_barang" name="kode_barang"
                       value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                @error('kode_barang')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang"
                       value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                @error('nama_barang')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori" required>
                    @foreach (['Makanan', 'Minuman', 'Sembako', 'Kebutuhan Rumah', 'Lainnya'] as $kategori)
                        <option value="{{ $kategori }}"
                            @selected(old('kategori', $barang->kategori) == $kategori)>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="satuan">Satuan</label>
                <select id="satuan" name="satuan" required>
                    @foreach (['pcs', 'kg', 'liter', 'dus', 'pak', 'botol', 'karung'] as $satuan)
                        <option value="{{ $satuan }}"
                            @selected(old('satuan', $barang->satuan) == $satuan)>
                            {{ $satuan }}
                        </option>
                    @endforeach
                </select>
                @error('satuan')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="harga_beli">Harga Beli</label>
                <input type="number" id="harga_beli" name="harga_beli"
                       value="{{ old('harga_beli', $barang->harga_beli) }}"
                       min="0" step="0.01" required>
                @error('harga_beli')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="harga_jual">Harga Jual</label>
                <input type="number" id="harga_jual" name="harga_jual"
                       value="{{ old('harga_jual', $barang->harga_jual) }}"
                       min="0" step="0.01" required>
                @error('harga_jual')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok"
                       value="{{ old('stok', $barang->stok) }}"
                       min="0" required>
                @error('stok')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stok_minimum">Stok Minimum</label>
                <input type="number" id="stok_minimum" name="stok_minimum"
                       value="{{ old('stok_minimum', $barang->stok_minimum) }}"
                       min="0" required>
                @error('stok_minimum')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-save">
                    Update Barang
                </button>

                <a href="{{ route('barang.index') }}" class="btn btn-back">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
