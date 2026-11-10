@extends('layouts.app')

@section('title', $category->exists ? 'Ubah Kategori' : 'Tambah Kategori')
@section('subtitle', $category->exists ? 'Perbarui keterangan kategori.' : 'Tambahkan kelompok buku baru.')

@section('content')
    <div class="card" style="max-width: 640px">
        <div class="card-body">
            <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
                @csrf
                @if ($category->exists)
                    @method('PUT')
                @endif

                <div class="field">
                    <label for="name">Nama Kategori</label>
                    <input class="input" id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Deskripsi</label>
                    <textarea class="input" id="description" name="description">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-ghost" href="{{ route('categories.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
