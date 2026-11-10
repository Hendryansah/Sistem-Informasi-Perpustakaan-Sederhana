@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan kondisi perpustakaan per hari ini.')

@section('content')
    <div class="stats">
        <div class="stat" style="--accent: #1E3A2E">
            <div class="stat-label">Judul Buku</div>
            <div class="stat-value">{{ $stats['titles'] }}</div>
            <div class="stat-note">judul terdaftar di katalog</div>
        </div>
        <div class="stat" style="--accent: #3E5A3F">
            <div class="stat-label">Total Stok</div>
            <div class="stat-value">{{ $stats['stock'] }}</div>
            <div class="stat-note">eksemplar tersimpan di rak</div>
        </div>
        <div class="stat" style="--accent: #6B7F67">
            <div class="stat-label">Anggota</div>
            <div class="stat-value">{{ $stats['members'] }}</div>
            <div class="stat-note">anggota terdaftar</div>
        </div>
        <div class="stat" style="--accent: #8C4A34">
            <div class="stat-label">Sedang Dipinjam</div>
            <div class="stat-value">{{ $stats['borrowed'] }}</div>
            <div class="stat-note">transaksi belum kembali</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Peminjaman Berjalan</h2>
            <a class="btn btn-primary btn-sm" href="{{ route('borrowings.create') }}">Catat Peminjaman</a>
        </div>
        @forelse ($activeBorrowings as $borrowing)
            @if ($loop->first)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Anggota</th>
                        <th>Buku Dipinjam</th>
                        <th>Jatuh Tempo</th>
                    </tr>
                    </thead>
                    <tbody>
            @endif
            <tr>
                <td><a href="{{ route('borrowings.show', $borrowing) }}">{{ $borrowing->code }}</a></td>
                <td>{{ $borrowing->member->name }}</td>
                <td>{{ $borrowing->books->sum(fn ($book) => $book->pivot->qty) }} eksemplar</td>
                <td>
                    {{ $borrowing->due_date->translatedFormat('d M Y') }}
                    @if ($borrowing->isOverdue())
                        <span class="badge badge-overdue">Terlambat</span>
                    @endif
                </td>
            </tr>
            @if ($loop->last)
                </tbody>
                </table>
            @endif
        @empty
            <div class="empty">Tidak ada peminjaman yang sedang berjalan.</div>
        @endforelse
    </div>
@endsection
