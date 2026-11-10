<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') &mdash; SI Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-name">Perpustakaan</div>
            <div class="brand-sub">Sistem Informasi</div>
        </div>
        <nav class="nav">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">Buku</a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
            <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">Anggota</a>
            <a href="{{ route('borrowings.index') }}" class="{{ request()->routeIs('borrowings.*') ? 'active' : '' }}">Peminjaman</a>
            @if (auth()->user()->isAdmin())
                <div class="nav-label">Administrasi</div>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Pengguna</a>
            @endif
        </nav>
        <div class="sidebar-foot">UAS &mdash; Pemrograman Web Framework</div>
    </aside>
    <div class="main">
        <header class="topbar">
            <div>
                <h1 class="page-title">@yield('title')</h1>
                @hasSection('subtitle')
                    <div class="page-sub">@yield('subtitle')</div>
                @endif
            </div>
            <div class="userchip">
                <span>{{ auth()->user()->name }}</span>
                <span class="badge badge-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Keluar</button>
                </form>
            </div>
        </header>
        <main class="content">
            @if (session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
