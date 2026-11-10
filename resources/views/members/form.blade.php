@extends('layouts.app')

@section('title', $member->exists ? 'Ubah Anggota' : 'Tambah Anggota')
@section('subtitle', $member->exists ? 'Perbarui data anggota '.$member->code.'.' : 'Daftarkan anggota baru perpustakaan.')

@section('content')
    <div class="card" style="max-width: 680px">
        <div class="card-body">
            <form method="POST" action="{{ $member->exists ? route('members.update', $member) : route('members.store') }}">
                @csrf
                @if ($member->exists)
                    @method('PUT')
                @endif

                @if ($member->exists)
                    <div class="field">
                        <label>Kode Anggota</label>
                        <input class="input" type="text" value="{{ $member->code }}" disabled>
                        <div class="muted" style="font-size: 12px; margin-top: 4px">Kode dibuat otomatis oleh sistem dan tidak dapat diubah.</div>
                    </div>
                @endif

                <div class="field">
                    <label for="name">Nama Lengkap</label>
                    <input class="input" id="name" type="text" name="name" value="{{ old('name', $member->name) }}" required>
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label for="email">Email</label>
                        <input class="input" id="email" type="email" name="email" value="{{ old('email', $member->email) }}">
                        @error('email')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="phone">Nomor Telepon</label>
                        <input class="input" id="phone" type="text" name="phone" value="{{ old('phone', $member->phone) }}">
                        @error('phone')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="address">Alamat</label>
                    <textarea class="input" id="address" name="address">{{ old('address', $member->address) }}</textarea>
                    @error('address')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-ghost" href="{{ $member->exists ? route('members.show', $member) : route('members.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
