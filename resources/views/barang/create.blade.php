@extends('layouts.app')

@section('title', 'Tambah Barang - Rotasi Stok')
@section('heading', 'Tambah Barang')
@section('subheading', 'Tambahkan data persediaan barang baru.')

@push('styles')
    <style>
        .form-card {
            max-width: 850px;
        }

        .form-card h2 {
            color: var(--app-heading);
            font-size: 18px;
        }

        .description {
            margin: 6px 0 24px;
            color: var(--app-muted);
            font-size: 13px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--app-heading);
            font-size: 13px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            color: var(--app-text);
            background: var(--app-surface);
            border: 1px solid #e0e5ef;
            border-radius: 8px;
            outline: none;
            font-size: 13px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 3px rgba(36, 120, 220, .1);
        }

        .error {
            margin-top: 6px;
            color: var(--app-danger);
            font-size: 12px;
        }

        .alert {
            padding: 12px;
            margin-bottom: 18px;
            color: #c43d52;
            background: #fff0f0;
            border-radius: 8px;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
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

        .btn-cancel {
            color: #596780;
            background: #e9edf5;
        }

        @media (max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn {
                flex: 1;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="panel form-card">
        <h2>📦 Form Tambah Barang</h2>
        <p class="description">Lengkapi informasi barang di bawah ini.</p>

        @if($errors->any())
            <div class="alert">
                <strong>Periksa kembali data yang dimasukkan:</strong>
                <ul style="margin:8px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" id="kode_barang" name="kode_barang"
                           value="{{ old('kode_barang') }}"
                           placeholder="Contoh: BRG002" required>
                    @error('kode_barang')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang"
                           value="{{ old('nama_barang') }}"
                           placeholder="Masukkan nama barang" required>
                    @error('nama_barang')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori"
                           value="{{ old('kategori') }}"
                           placeholder="Contoh: Sembako" required>
                    @error('kategori')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <select id="satuan" name="satuan" required>
                        <option value="">-- Pilih Satuan --</option>
                        @foreach(['pcs','kg','liter','dus','pak','botol','karung'] as $satuan)
                            <option value="{{ $satuan }}"
                                {{ old('satuan') == $satuan ? 'selected' : '' }}>
                                {{ ucfirst($satuan) }}
                            </option>
                        @endforeach
                    </select>
                    @error('satuan')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga_beli">Harga Beli (Rp)</label>
                    <input type="number" id="harga_beli" name="harga_beli"
                           value="{{ old('harga_beli') }}"
                           min="0" placeholder="Contoh: 12000" required>
                    @error('harga_beli')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga_jual">Harga Jual (Rp)</label>
                    <input type="number" id="harga_jual" name="harga_jual"
                           value="{{ old('harga_jual') }}"
                           min="0" placeholder="Contoh: 15000" required>
                    @error('harga_jual')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stok">Stok Awal</label>
                    <input type="number" id="stok" name="stok"
                           value="{{ old('stok', 0) }}"
                           min="0" placeholder="Masukkan jumlah stok" required>
                    @error('stok')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stok_minimum">Stok Minimum</label>
                    <input type="number" id="stok_minimum" name="stok_minimum"
                           value="{{ old('stok_minimum', 5) }}"
                           min="0" placeholder="Contoh: 5" required>
                    @error('stok_minimum')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">
                    💾 Simpan Barang
                </button>

                <a href="{{ route('barang.index') }}" class="btn btn-cancel">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
