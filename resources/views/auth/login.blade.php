@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="login-card">
        <div class="login-brand">Perpustakaan</div>
        <p class="login-sub">Masuk untuk mengelola data buku, anggota, dan peminjaman.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="field">
                <label for="password">Kata Sandi</label>
                <input class="input" id="password" type="password" name="password" required>
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>
            <label class="check">
                <input type="checkbox" name="remember" value="1">
                Ingat saya di perangkat ini
            </label>
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>

        <div class="login-hint">
            Akun contoh:<br>
            admin@perpus.id &middot; password (admin)<br>
            petugas@perpus.id &middot; password (petugas)
        </div>
    </div>
@endsection
