@extends('layouts.app')

@section('title', $book->exists ? 'Ubah Buku' : 'Tambah Buku')
@section('subtitle', $book->exists ? 'Perbarui data buku '.$book->title.'.' : 'Masukkan buku baru ke katalog.')

@section('content')
    <div class="card" style="max-width: 760px">
        <div class="card-body">
            <form method="POST" action="{{ $book->exists ? route('books.update', $book) : route('books.store') }}">
                @csrf
                @if ($book->exists)
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div class="field span-2">
                        <label for="title">Judul Buku</label>
                        <input class="input" id="title" type="text" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="author">Penulis</label>
                        <input class="input" id="author" type="text" name="author" value="{{ old('author', $book->author) }}" required>
                        @error('author')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="category_id">Kategori</label>
                        <select class="input" id="category_id" name="category_id" required>
                            <option value="">— pilih kategori —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((int) old('category_id', $book->category_id) === $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="publisher">Penerbit</label>
                        <input class="input" id="publisher" type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                        @error('publisher')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="published_year">Tahun Terbit</label>
                        <input class="input" id="published_year" type="number" name="published_year" min="1900" max="{{ now()->year }}"
                               value="{{ old('published_year', $book->published_year) }}">
                        @error('published_year')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="isbn">ISBN</label>
                        <input class="input" id="isbn" type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                        @error('isbn')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="stock">Stok</label>
                        <input class="input" id="stock" type="number" name="stock" min="0" value="{{ old('stock', $book->stock ?? 0) }}" required>
                        @error('stock')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field span-2">
                        <label for="synopsis">Sinopsis Singkat</label>
                        <textarea class="input" id="synopsis" name="synopsis">{{ old('synopsis', $book->synopsis) }}</textarea>
                        @error('synopsis')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-ghost" href="{{ $book->exists ? route('books.show', $book) : route('books.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
