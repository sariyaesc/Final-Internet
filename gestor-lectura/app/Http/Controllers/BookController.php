<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('addedBy')->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'nullable|string|max:20',
            'cover_url'   => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'genre'       => 'nullable|string|max:100',
            'total_pages' => 'required|integer|min:1',
        ]);

        $validated['added_by'] = Auth::id();
        Book::create($validated);

        return redirect()->route('books.index')
                         ->with('success', 'Libro agregado correctamente.');
    }

    public function show(Book $book)
    {
        $book->load(['notes' => fn($q) => $q->where('user_id', Auth::id())]);
        $progress = $book->readingProgress()
                         ->where('user_id', Auth::id())
                         ->first();
        return view('books.show', compact('book', 'progress'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'nullable|string|max:20',
            'cover_url'   => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'genre'       => 'nullable|string|max:100',
            'total_pages' => 'required|integer|min:1',
        ]);

        $book->update($validated);

        return redirect()->route('books.show', $book)
                         ->with('success', 'Libro actualizado.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')
                         ->with('success', 'Libro eliminado.');
    }
}