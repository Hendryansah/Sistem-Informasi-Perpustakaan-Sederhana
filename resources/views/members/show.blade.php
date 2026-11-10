@extends('layouts.app')

@section('title', $member->name)
@section('subtitle', 'Profil anggota beserta riwayat peminjamannya.')

@section('content')
    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Data Anggota</h2>
            <div class="row-actions">
                <a class="btn btn-ghost btn-sm" href="{{ route('members.edit', $member) }}">Ubah</a>
                <form method="POST" action="{{ route('members.destroy', $member) }}"
                      onsubmit="return confirm('Hapus anggota {{ $member->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <dl class="detail-grid">
                <dt>Kode Anggota</dt>
                <dd>{{ $member->code }}</dd>
                <dt>Nama</dt>
                <dd>{{ $member->name }}</dd>
                <dt>Email</dt>
                <dd>{{ $member->email ?? '—' }}</dd>
                <dt>Nomor Telepon</dt>
                <dd>{{ $member->phone ?? '—' }}</dd>
                <dt>Alamat</dt>
                <dd>{{ $member->address ?? '—' }}</dd>
                <dt>Terdaftar Sejak</dt>
                <dd>{{ $member->created_at->translatedFormat('d M Y') }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Riwayat Peminjaman</h2>
            <a class="btn btn-primary btn-sm" href="{{ route('borrowings.create') }}">Catat Peminjaman</a>
        </div>
        @forelse ($history as $borrowing)
            @if ($loop->first)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Buku Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
            @endif
            <tr>
                <td><a href="{{ route('borrowings.show', $borrowing) }}">{{ $borrowing->code }}</a></td>
                <td>
                    @foreach ($borrowing->books as $book)
                        {{ $book->title }} ({{ $book->pivot->qty }})@if (! $loop->last), @endif
                    @endforeach
                </td>
                <td>{{ $borrowing->borrow_date->translatedFormat('d M Y') }}</td>
                <td>{{ $borrowing->due_date->translatedFormat('d M Y') }}</td>
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
            <div class="empty">Anggota ini belum pernah meminjam buku.</div>
        @endforelse
    </div>

    {{ $history->links() }}
@endsection
