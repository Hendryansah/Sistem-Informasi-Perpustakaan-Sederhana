<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->toString();

        $books = Book::with('category')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($inner) use ($q) {
                    $inner->where('title', 'like', "%{$q}%")
                        ->orWhere('author', 'like', "%{$q}%")
                        ->orWhere('isbn', 'like', "%{$q}%");
                });
            })
            ->orderBy('title')
            ->paginate(8)
            ->withQueryString();

        return view('books.index', ['books' => $books, 'q' => $q]);
    }

    public function show(Book $book): View
    {
        $book->load('category');

        $history = $book->borrowings()->with('member')->latest()->limit(8)->get();

        return view('books.show', ['book' => $book, 'history' => $history]);
    }

    public function create(): View
    {
        return view('books.form', [
            'book' => new Book,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Book::create($this->validateBook($request));

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book): View
    {
        return view('books.form', [
            'book' => $book,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $book->update($this->validateBook($request));

        return redirect()->route('books.show', $book)->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->borrowings()->exists()) {
            return back()->with('error', 'Buku masih memiliki riwayat peminjaman sehingga tidak bisa dihapus.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function validateBook(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:150'],
            'author' => ['required', 'string', 'max:100'],
            'publisher' => ['nullable', 'string', 'max:100'],
            'published_year' => ['nullable', 'integer', 'min:1900', 'max:'.now()->year],
            'isbn' => ['nullable', 'string', 'max:32'],
            'synopsis' => ['nullable', 'string', 'max:2000'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
        ]);
    }
}
