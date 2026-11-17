@extends('layouts.app')

@section('title', 'Kategori')
@section('subtitle', 'Pengelompokan buku di katalog perpustakaan.')

@section('content')
    <div class="toolbar">
        <div class="muted">{{ $categories->count() }} kategori terdaftar</div>
        @if (auth()->user()->isAdmin())
            <a class="btn btn-primary" href="{{ route('categories.create') }}">Tambah Kategori</a>
        @else
            <span class="badge badge-flat">mode lihat saja untuk petugas</span>
        @endif
    </div>

    <div class="card">
        <table class="table">
            <thead>
            <tr>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Buku</th>
                @if (auth()->user()->isAdmin())
                    <th style="text-align: right">Aksi</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="muted">{{ $category->description ?? '—' }}</td>
                    <td>{{ $category->books_count }} judul</td>
                    @if (auth()->user()->isAdmin())
                        <td>
                            <div class="row-actions">
                                <a class="btn btn-ghost btn-sm" href="{{ route('categories.edit', $category) }}">Ubah</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="4"><div class="empty">Belum ada kategori.</div></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
