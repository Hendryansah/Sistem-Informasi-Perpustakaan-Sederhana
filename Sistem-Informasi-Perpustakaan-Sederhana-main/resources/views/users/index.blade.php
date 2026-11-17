@extends('layouts.app')

@section('title', 'Pengguna')
@section('subtitle', 'Akun admin dan petugas yang bisa masuk ke sistem.')

@section('content')
    <div class="toolbar">
        <div class="muted">{{ $users->total() }} pengguna terdaftar</div>
        <a class="btn btn-primary" href="{{ route('users.create') }}">Tambah Pengguna</a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th style="text-align: right">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>
                        {{ $user->name }}
                        @if ($user->id === auth()->id())
                            <span class="badge badge-flat">akun ini</span>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <div class="row-actions">
                            <a class="btn btn-ghost btn-sm" href="{{ route('users.edit', $user) }}">Ubah</a>
                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4"><div class="empty">Belum ada pengguna.</div></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
@endsection
