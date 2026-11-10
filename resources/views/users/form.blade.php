@extends('layouts.app')

@section('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')
@section('subtitle', $user->exists ? 'Perbarui data akun '.$user->name.'.' : 'Buat akun baru untuk admin atau petugas.')

@section('content')
    <div class="card" style="max-width: 640px">
        <div class="card-body">
            <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}">
                @csrf
                @if ($user->exists)
                    @method('PUT')
                @endif

                <div class="field">
                    <label for="name">Nama Lengkap</label>
                    <input class="input" id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input class="input" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="role">Role</label>
                    <select class="input" id="role" name="role" required>
                        <option value="petugas" @selected(old('role', $user->role) === 'petugas')>Petugas</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                    @error('role')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Kata Sandi</label>
                    <input class="input" id="password" type="password" name="password" @required(! $user->exists)>
                    @if ($user->exists)
                        <div class="muted" style="font-size: 12px; margin-top: 4px">Kosongkan bila kata sandi tidak ingin diganti.</div>
                    @endif
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-ghost" href="{{ route('users.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
