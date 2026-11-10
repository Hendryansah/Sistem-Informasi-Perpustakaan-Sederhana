<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'titles' => Book::count(),
            'stock' => (int) Book::sum('stock'),
            'members' => Member::count(),
            'borrowed' => Borrowing::where('status', 'borrowed')->count(),
        ];

        $activeBorrowings = Borrowing::with('member', 'books')
            ->where('status', 'borrowed')
            ->latest()
            ->limit(6)
            ->get();

        return view('dashboard', compact('stats', 'activeBorrowings'));
    }
}
