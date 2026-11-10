<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->toString();

        $members = Member::when($q !== '', function ($query) use ($q) {
            $query->where(function ($inner) use ($q) {
                $inner->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('members.index', ['members' => $members, 'q' => $q]);
    }

    public function show(Member $member): View
    {
        $history = $member->borrowings()->with('books')->latest()->paginate(6);

        return view('members.show', ['member' => $member, 'history' => $history]);
    }

    public function create(): View
    {
        return view('members.form', ['member' => new Member]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateMember($request);
        $data['code'] = $this->nextCode();

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member): View
    {
        return view('members.form', ['member' => $member]);
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $member->update($this->validateMember($request, $member));

        return redirect()->route('members.show', $member)->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        if ($member->borrowings()->exists()) {
            return back()->with('error', 'Anggota masih memiliki riwayat peminjaman sehingga tidak bisa dihapus.');
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    private function validateMember(Request $request, ?Member $member = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150', Rule::unique('members', 'email')->ignore($member)],
            'phone' => ['nullable', 'string', 'max:24'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);
    }

    private function nextCode(): string
    {
        $number = Member::count() + 1;

        do {
            $code = sprintf('AGT-%04d', $number++);
        } while (Member::where('code', $code)->exists());

        return $code;
    }
}
