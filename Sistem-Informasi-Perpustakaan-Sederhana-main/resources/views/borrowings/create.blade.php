@extends('layouts.app')

@section('title', 'Catat Peminjaman')
@section('subtitle', 'Tanggal pinjam diisi hari ini dan jatuh tempo otomatis 7 hari kemudian.')

@section('content')
    <div class="card" style="max-width: 860px">
        <div class="card-body">
            <form method="POST" action="{{ route('borrowings.store') }}">
                @csrf

                <div class="form-grid">
                    <div class="field">
                        <label for="member_id">Anggota Peminjam</label>
                        <select class="input" id="member_id" name="member_id" required>
                            <option value="">— pilih anggota —</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" @selected((int) old('member_id') === $member->id)>
                                    {{ $member->code }} &mdash; {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Dicatat Oleh</label>
                        <input class="input" type="text" value="{{ auth()->user()->name }} ({{ auth()->user()->role }})" disabled>
                    </div>
                </div>

                <div class="field">
                    <label>Buku yang Dipinjam</label>
                    <div id="borrow-items">
                        <div class="borrow-row">
                            <select class="input" name="items[0][book_id]" required>
                                <option value="">— pilih buku —</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">
                                        {{ $book->title }} (stok {{ $book->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <input class="input" type="number" name="items[0][qty]" min="1" max="99" value="1" required>
                            <button type="button" class="btn btn-danger btn-sm row-remove">Buang</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-ghost btn-sm" id="add-row">+ Tambah baris buku</button>
                    @if ($errors->has('items') || $errors->has('items.*.book_id') || $errors->has('items.*.qty'))
                        <div class="error-text">
                            {{ $errors->first('items') ?: ($errors->first('items.*.book_id') ?: $errors->first('items.*.qty')) }}
                        </div>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
                    <a class="btn btn-ghost" href="{{ route('borrowings.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <template id="row-template">
        <div class="borrow-row">
            <select class="input" name="items[__IDX__][book_id]" required>
                <option value="">— pilih buku —</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">
                        {{ $book->title }} (stok {{ $book->stock }})
                    </option>
                @endforeach
            </select>
            <input class="input" type="number" name="items[__IDX__][qty]" min="1" max="99" value="1" required>
            <button type="button" class="btn btn-danger btn-sm row-remove">Buang</button>
        </div>
    </template>

    @push('scripts')
        <script>
            let nextIndex = 1;
            const wrapper = document.getElementById('borrow-items');
            const template = document.getElementById('row-template');

            document.getElementById('add-row').addEventListener('click', () => {
                wrapper.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__IDX__', nextIndex++));
            });

            wrapper.addEventListener('click', (event) => {
                const button = event.target.closest('.row-remove');

                if (button && wrapper.children.length > 1) {
                    button.closest('.borrow-row').remove();
                }
            });
        </script>
    @endpush
@endsection
