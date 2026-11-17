@extends('layouts.app')

@section('title', 'Anggota')
@section('subtitle', 'Data anggota yang bisa meminjam buku.')

@section('content')
    <div class="toolbar">
        <form class="searchbar" method="GET" action="{{ route('members.index') }}">
            <input class="input" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau kode anggota...">
            <button type="submit" class="btn btn-ghost">Cari</button>
            @if ($q !== '')
                <a class="btn btn-ghost" href="{{ route('members.index') }}">Bersihkan</a>
            @endif
        </form>
        <a class="btn btn-primary" href="{{ route('members.create') }}">Tambah Anggota</a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kontak</th>
                <th style="text-align: right">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member->code }}</td>
                    <td><a href="{{ route('members.show', $member) }}">{{ $member->name }}</a></td>
                    <td class="muted">{{ $member->phone ?? $member->email ?? '—' }}</td>
                    <td>
                        <div class="row-actions">
                            <a class="btn btn-ghost btn-sm" href="{{ route('members.show', $member) }}">Detail</a>
                            <a class="btn btn-ghost btn-sm" href="{{ route('members.edit', $member) }}">Ubah</a>
                            <form method="POST" action="{{ route('members.destroy', $member) }}"
                                  onsubmit="return confirm('Hapus anggota {{ $member->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <div class="empty">
                            @if ($q !== '')
                                Tidak ada anggota yang cocok dengan pencarian "{{ $q }}".
                            @else
                                Belum ada anggota terdaftar.
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $members->links() }}
@endsection
