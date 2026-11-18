@extends('layouts.app')

@section('title', 'Profil Admin | Rotasi Stok Retail')
@section('heading', 'Profil Admin')
@section('subheading', 'Kelola informasi akun administrator Rotasi Stok Retail.')

@push('styles')
    <style>
        .profile-card {
            max-width: 900px;
        }

        .profile-top {
            display: flex;
            align-items: center;
            gap: 18px;
            padding-bottom: 25px;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--app-border);
        }

        .profile-avatar {
            display: grid;
            place-items: center;
            flex: 0 0 72px;
            width: 72px;
            height: 72px;
            font-size: 32px;
            background: #e5efff;
            border-radius: 50%;
        }

        .profile-top h2 {
            margin-bottom: 5px;
            color: var(--app-heading);
            font-size: 20px;
        }

        .profile-top p {
            color: var(--app-muted);
            font-size: 13px;
        }

        .section-title {
            margin: 25px 0 18px;
            padding-bottom: 12px;
            color: var(--app-heading);
            font-size: 16px;
            border-bottom: 1px solid var(--app-border);
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
            padding: 12px 14px;
            color: var(--app-text);
            background: var(--app-surface);
            border: 1px solid #dce3ec;
            border-radius: 9px;
            outline: none;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 3px rgba(36, 120, 220, .1);
        }

        .info {
            margin-bottom: 20px;
            color: var(--app-muted);
            font-size: 13px;
        }

        .success {
            padding: 14px;
            margin-bottom: 20px;
            color: #237746;
            background: #e4f7eb;
            border-radius: 9px;
        }

        .error {
            margin-top: 6px;
            color: var(--app-danger);
            font-size: 13px;
        }

        .error-box {
            padding: 12px 14px;
            margin-bottom: 20px;
            color: #b83232;
            background: #fff0f0;
            border-radius: 9px;
            font-size: 13px;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 22px;
            border: none;
            border-radius: 9px;
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
            color: #344054;
            background: #e8edf3;
        }

        @media (max-width: 600px) {
            .profile-top {
                align-items: flex-start;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="panel profile-card">
        <div class="profile-top">
            <div class="profile-avatar" aria-hidden="true">👤</div>

            <div>
                <h2>{{ $user->name }}</h2>
                <p>Administrator Rotasi Stok Retail</p>
            </div>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-box">
                Ada data yang belum benar. Silakan periksa kembali.
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <h3 class="section-title">Informasi Akun</h3>

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
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
                       value="{{ old('username', $user->username) }}"
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
                       value="{{ old('email', $user->email) }}"
                       required>

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <h3 class="section-title">Ganti Password</h3>

            <p class="info">
                Kosongkan kedua kolom password jika tidak ingin menggantinya.
            </p>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Masukkan password baru"
                       autocomplete="new-password">

                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Ulangi password baru"
                       autocomplete="new-password">
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-save">
                    💾 Simpan Perubahan
                </button>

                <a href="{{ route('dashboard') }}" class="btn btn-back">
                    ← Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
