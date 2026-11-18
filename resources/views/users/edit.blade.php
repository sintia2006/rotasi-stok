@extends('layouts.app')

@section('title', 'Edit Pengguna | Rotasi Stok Retail')
@section('heading', 'Edit Pengguna')
@section('subheading', 'Perbarui informasi akun pengguna.')

@push('styles')
    <style>
        .form-card {
            max-width: 650px;
        }

        .form-card h2 {
            color: var(--app-heading);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: var(--app-heading);
            font-size: 14px;
            font-weight: 700;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            color: var(--app-text);
            background: var(--app-surface);
            border: 1px solid #dce2ec;
            border-radius: 8px;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 3px rgba(36, 120, 220, .1);
        }

        .hint {
            margin-top: 6px;
            color: var(--app-muted);
            font-size: 12px;
        }

        .error {
            margin-top: 5px;
            color: var(--app-danger);
            font-size: 13px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 700;
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
            background: #e9edf4;
        }
    </style>
@endpush

@section('content')
    <div class="panel form-card">
        @if ($errors->any())
            <div class="error">
                <ul style="margin-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                       value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password">
                <div class="hint">Kosongkan jika tidak ingin mengganti password.</div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-save">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="btn btn-back">Kembali</a>
            </div>
        </form>
    </div>
@endsection
