@extends('layouts.app')

@section('title', 'Data Buku')
@section('subtitle', 'Katalog buku beserta stok dan kategorinya.')

@section('content')
    <div class="toolbar">
        <form class="searchbar" method="GET" action="{{ route('books.index') }}">
            <input class="input" type="search" name="q" value="{{ $q }}" placeholder="Cari judul, penulis, atau ISBN...">
            <button type="submit" class="btn btn-ghost">Cari</button>
            @if ($q !== '')
                <a class="btn btn-ghost" href="{{ route('books.index') }}">Bersihkan</a>
            @endif
        </form>
        <a class="btn btn-primary" href="{{ route('books.create') }}">Tambah Buku</a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th style="text-align: right">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>
                        <a href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
                        @if ($book->published_year)
                            <div class="muted">{{ $book->published_year }}</div>
                        @endif
                    </td>
                    <td>{{ $book->author }}</td>
                    <td><span class="badge badge-flat">{{ $book->category->name }}</span></td>
                    <td>
                        @if ($book->stock > 0)
                            {{ $book->stock }} eksemplar
                        @else
                            <span class="badge badge-overdue">Stok habis</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            <a class="btn btn-ghost btn-sm" href="{{ route('books.show', $book) }}">Detail</a>
                            <a class="btn btn-ghost btn-sm" href="{{ route('books.edit', $book) }}">Ubah</a>
                            <form method="POST" action="{{ route('books.destroy', $book) }}"
                                  onsubmit="return confirm('Hapus buku {{ $book->title }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty">
                            @if ($q !== '')
                                Tidak ada buku yang cocok dengan pencarian "{{ $q }}".
                            @else
                                Belum ada buku terdaftar.
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $books->links() }}
@endsection
