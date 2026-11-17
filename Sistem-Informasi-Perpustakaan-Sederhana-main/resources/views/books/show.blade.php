@extends('layouts.app')

@section('title', $book->title)
@section('subtitle', 'Detail buku dan riwayat peminjamannya.')

@section('content')
    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Informasi Buku</h2>
            <div class="row-actions">
                <a class="btn btn-ghost btn-sm" href="{{ route('books.edit', $book) }}">Ubah</a>
                <form method="POST" action="{{ route('books.destroy', $book) }}"
                      onsubmit="return confirm('Hapus buku {{ $book->title }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <dl class="detail-grid">
                <dt>Judul</dt>
                <dd>{{ $book->title }}</dd>
                <dt>Penulis</dt>
                <dd>{{ $book->author }}</dd>
                <dt>Kategori</dt>
                <dd>{{ $book->category->name }}</dd>
                <dt>Penerbit</dt>
                <dd>{{ $book->publisher ?? '—' }}</dd>
                <dt>Tahun Terbit</dt>
                <dd>{{ $book->published_year ?? '—' }}</dd>
                <dt>ISBN</dt>
                <dd>{{ $book->isbn ?? '—' }}</dd>
                <dt>Stok Tersedia</dt>
                <dd>
                    @if ($book->stock > 0)
                        {{ $book->stock }} eksemplar
                    @else
                        <span class="badge badge-overdue">Stok habis</span>
                    @endif
                </dd>
                <dt>Sinopsis</dt>
                <dd>{{ $book->synopsis ?? '—' }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Riwayat Peminjaman</h2>
        </div>
        @forelse ($history as $borrowing)
            @if ($loop->first)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
            @endif
            <tr>
                <td><a href="{{ route('borrowings.show', $borrowing) }}">{{ $borrowing->code }}</a></td>
                <td>{{ $borrowing->member->name }}</td>
                <td>{{ $borrowing->borrow_date->translatedFormat('d M Y') }}</td>
                <td>
                    @if ($borrowing->isReturned())
                        <span class="badge badge-returned">Dikembalikan</span>
                    @elseif ($borrowing->isOverdue())
                        <span class="badge badge-overdue">Terlambat</span>
                    @else
                        <span class="badge badge-borrowed">Dipinjam</span>
                    @endif
                </td>
            </tr>
            @if ($loop->last)
                </tbody>
                </table>
            @endif
        @empty
            <div class="empty">Buku ini belum pernah dipinjam.</div>
        @endforelse
    </div>
@endsection
