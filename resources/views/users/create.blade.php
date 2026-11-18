@extends('layouts.app')

@section('title', 'Tambah Pengguna | Rotasi Stok Retail')
@section('heading', 'Tambah Pengguna')
@section('subheading', 'Tambahkan akun pengguna baru ke sistem.')

@push('styles')
    <style>
        .form-card {
            max-width: 750px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--app-heading);
            font-size: 14px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px 13px;
            color: var(--app-text);
            background: var(--app-surface);
            border: 1px solid #dce3ec;
            border-radius: 8px;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 3px rgba(36, 120, 220, .1);
        }

        .error {
            margin-top: 6px;
            color: var(--app-danger);
            font-size: 13px;
        }

        .info {
            margin-bottom: 22px;
            padding: 13px;
            color: #3566a0;
            background: #edf5ff;
            border-radius: 8px;
            font-size: 13px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
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
    </style>
@endpush

@section('content')
    <div class="panel form-card">
        <div class="info">
            Lengkapi seluruh informasi di bawah untuk membuat akun pengguna baru.
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama lengkap"
                       required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text"
                       id="username"
                       name="username"
                       value="{{ old('username') }}"
                       placeholder="Masukkan username"
                       required>
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Masukkan email"
                       required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Minimal 8 karakter"
                       required
                       autocomplete="new-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Ulangi password"
                       required
                       autocomplete="new-password">
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-save">
                    Simpan Pengguna
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-back">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
