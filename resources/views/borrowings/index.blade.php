@extends('layouts.app')

@section('title', 'Peminjaman')
@section('subtitle', 'Transaksi peminjaman dan pengembalian buku.')

@section('content')
    <div class="toolbar">
        <div class="filter-links">
            @if ($status === '')
                <span>Semua</span>
            @else
                <a href="{{ route('borrowings.index') }}">Semua</a>
            @endif
            @if ($status === 'borrowed')
                <span>Sedang Dipinjam</span>
            @else
                <a href="{{ route('borrowings.index', ['status' => 'borrowed']) }}">Sedang Dipinjam</a>
            @endif
            @if ($status === 'returned')
                <span>Sudah Kembali</span>
            @else
                <a href="{{ route('borrowings.index', ['status' => 'returned']) }}">Sudah Kembali</a>
            @endif
        </div>
        <a class="btn btn-primary" href="{{ route('borrowings.create') }}">Catat Peminjaman</a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
            <tr>
                <th>Kode</th>
                <th>Anggota</th>
                <th>Tanggal Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Dicatat Oleh</th>
                <th>Status</th>
                <th style="text-align: right">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($borrowings as $borrowing)
                <tr>
                    <td><a href="{{ route('borrowings.show', $borrowing) }}">{{ $borrowing->code }}</a></td>
                    <td>{{ $borrowing->member->name }}</td>
                    <td>{{ $borrowing->borrow_date->translatedFormat('d M Y') }}</td>
                    <td>{{ $borrowing->due_date->translatedFormat('d M Y') }}</td>
                    <td class="muted">{{ $borrowing->officer->name }}</td>
                    <td>
                        @if ($borrowing->isReturned())
                            <span class="badge badge-returned">Dikembalikan</span>
                        @elseif ($borrowing->isOverdue())
                            <span class="badge badge-overdue">Terlambat</span>
                        @else
                            <span class="badge badge-borrowed">Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            <a class="btn btn-ghost btn-sm" href="{{ route('borrowings.show', $borrowing) }}">Detail</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7"><div class="empty">Belum ada transaksi peminjaman.</div></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $borrowings->links() }}
@endsection
