<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $borrowings = Borrowing::with('member', 'officer', 'books')
            ->when(in_array($status, ['borrowed', 'returned'], true), fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('borrowings.index', ['borrowings' => $borrowings, 'status' => $status]);
    }

    public function create(): View
    {
        return view('borrowings.create', [
            'members' => Member::orderBy('name')->get(),
            'books' => Book::with('category')->where('stock', '>', 0)->orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.book_id' => ['required', 'integer', 'exists:books,id'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $bookIds = collect($data['items'])->pluck('book_id');

        if ($bookIds->unique()->count() !== $bookIds->count()) {
            throw ValidationException::withMessages([
                'items' => 'Buku yang sama tidak boleh dimasukkan dua kali dalam satu transaksi.',
            ]);
        }

        foreach ($data['items'] as $item) {
            $book = Book::find($item['book_id']);

            if ($book->stock < $item['qty']) {
                throw ValidationException::withMessages([
                    'items' => "Stok \"{$book->title}\" tidak mencukupi, sisa {$book->stock} eksemplar.",
                ]);
            }
        }

        $borrowing = DB::transaction(function () use ($data) {
            $borrowing = Borrowing::create([
                'code' => $this->nextCode(),
                'user_id' => auth()->id(),
                'member_id' => $data['member_id'],
                'borrow_date' => now()->toDateString(),
                'due_date' => now()->addWeek()->toDateString(),
                'status' => 'borrowed',
            ]);

            foreach ($data['items'] as $item) {
                $borrowing->books()->attach($item['book_id'], ['qty' => $item['qty']]);
                Book::whereKey($item['book_id'])->decrement('stock', $item['qty']);
            }

            return $borrowing;
        });

        return redirect()
            ->route('borrowings.show', $borrowing)
            ->with('success', "Peminjaman {$borrowing->code} berhasil dicatat.");
    }

    public function show(Borrowing $borrowing): View
    {
        $borrowing->load('member', 'officer', 'books');

        return view('borrowings.show', ['borrowing' => $borrowing]);
    }

    public function return(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->isReturned()) {
            return back()->with('error', 'Peminjaman ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($borrowing) {
            $borrowing->update([
                'return_date' => now()->toDateString(),
                'status' => 'returned',
            ]);

            foreach ($borrowing->books as $book) {
                Book::whereKey($book->id)->increment('stock', $book->pivot->qty);
            }
        });

        return redirect()
            ->route('borrowings.show', $borrowing)
            ->with('success', "Pengembalian {$borrowing->code} berhasil dicatat.");
    }

    private function nextCode(): string
    {
        $number = Borrowing::whereYear('created_at', now()->year)->count() + 1;

        do {
            $code = sprintf('PJM-%d-%04d', now()->year, $number++);
        } while (Borrowing::where('code', $code)->exists());

        return $code;
    }
}
