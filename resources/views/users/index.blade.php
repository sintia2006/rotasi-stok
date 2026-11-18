@extends('layouts.app')

@section('title', 'Manajemen Pengguna | Rotasi Stok Retail')
@section('heading', 'Manajemen Pengguna')
@section('subheading', 'Kelola akun pengguna sistem Rotasi Stok Retail.')

@section('actions')
    <a href="{{ route('users.create') }}" class="btn btn-add">
        + Tambah Pengguna
    </a>
@endsection

@push('styles')
    <style>
        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-add {
            color: #fff;
            background: var(--app-primary);
        }

        .btn-add:hover {
            background: var(--app-primary-dark);
        }

        .btn-edit {
            color: #2875bd;
            background: #e6f0ff;
        }

        .btn-delete {
            color: #d33b3b;
            background: #fff0f0;
        }

        .btn-back {
            color: #39465a;
            background: #e9edf3;
        }

        .success,
        .error {
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .success {
            color: #237746;
            background: #e4f7eb;
        }

        .error {
            color: #b83232;
            background: #fff0f0;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .table-wrapper table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }

        .table-wrapper th {
            padding: 14px 15px;
            color: #526176;
            font-size: 12px;
            text-align: left;
            background: #f5f7fb;
        }

        .table-wrapper td {
            padding: 14px 15px;
            border-bottom: 1px solid #edf0f5;
            font-size: 13px;
        }

        .table-wrapper tr:hover td {
            background: #fafcff;
        }

        .user-name {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .user-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 35px;
            width: 35px;
            height: 35px;
            color: #2875bd;
            background: #e5efff;
            border-radius: 50%;
        }

        .badge-self {
            padding: 4px 8px;
            color: #2875bd;
            background: #edf5ff;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
            flex-wrap: wrap;
        }

        .actions form {
            display: inline;
        }

        .pagination {
            margin-top: 20px;
        }

        .bottom {
            margin-top: 22px;
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Tanggal Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="user-name">
                                    <span class="user-icon" aria-hidden="true">👤</span>
                                    <span>{{ $user->name }}</span>
                                    @if($user->id === auth()->id())
                                        <span class="badge-self">Anda</span>
                                    @endif
                                </div>
                            </td>

                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at?->format('d-m-Y') ?? '-' }}</td>

                            <td>
                                <div class="actions">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit">
                                        Edit
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:30px;color:var(--app-muted);">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
        </div>

        <div class="bottom">
            <a href="{{ route('dashboard') }}" class="btn btn-back">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
