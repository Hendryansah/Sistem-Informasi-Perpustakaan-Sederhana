@extends('layouts.app')

@section('title', 'Peminjaman '.$borrowing->code)
@section('subtitle', 'Rincian transaksi peminjaman buku.')

@section('content')
    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Informasi Transaksi</h2>
            @if (! $borrowing->isReturned())
                <form method="POST" action="{{ route('borrowings.return', $borrowing) }}"
                      onsubmit="return confirm('Proses pengembalian {{ $borrowing->code }}?')">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Proses Pengembalian</button>
                </form>
            @endif
        </div>
        <div class="card-body">
            <dl class="detail-grid">
                <dt>Kode Transaksi</dt>
                <dd>{{ $borrowing->code }}</dd>
                <dt>Anggota</dt>
                <dd>
                    <a href="{{ route('members.show', $borrowing->member) }}">{{ $borrowing->member->name }}</a>
                    ({{ $borrowing->member->code }})
                </dd>
                <dt>Dicatat Oleh</dt>
                <dd>{{ $borrowing->officer->name }} ({{ $borrowing->officer->role }})</dd>
                <dt>Tanggal Peminjaman</dt>
                <dd>{{ $borrowing->borrow_date->translatedFormat('d M Y') }}</dd>
                <dt>Jatuh Tempo</dt>
                <dd>
                    {{ $borrowing->due_date->translatedFormat('d M Y') }}
                    @if ($borrowing->isOverdue())
                        <span class="badge badge-overdue">Terlambat</span>
                    @endif
                </dd>
                <dt>Tanggal Pengembalian</dt>
                <dd>{{ $borrowing->return_date?->translatedFormat('d M Y') ?? '—' }}</dd>
                <dt>Status</dt>
                <dd>
                    @if ($borrowing->isReturned())
                        <span class="badge badge-returned">Dikembalikan</span>
                    @else
                        <span class="badge badge-borrowed">Dipinjam</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Buku yang Dipinjam</h2>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Jumlah</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($borrowing->books as $book)
                <tr>
                    <td><a href="{{ route('books.show', $book) }}">{{ $book->title }}</a></td>
                    <td><span class="badge badge-flat">{{ $book->category->name }}</span></td>
                    <td>{{ $book->pivot->qty }} eksemplar</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
