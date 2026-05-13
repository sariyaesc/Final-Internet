<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Book $book)
    {
        $notes = $book->notes()
                      ->where('user_id', Auth::id())
                      ->latest()
                      ->get();
        return view('notes.index', compact('book', 'notes'));
    }

    public function create()
    {
        $books = Book::all();
        return view('notes.create', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id'     => 'required|exists:books,id',
            'content'     => 'required|string|max:2000',
            'page_number' => 'nullable|integer|min:1',
        ]);

        $validated['user_id'] = Auth::id();
        Note::create($validated);

        return redirect()->route('notes.index', $validated['book_id'])
                         ->with('success', 'Nota guardada.');
    }

    public function edit(Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);
        $books = Book::all();
        return view('notes.edit', compact('note', 'books'));
    }

    public function update(Request $request, Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'content'     => 'required|string|max:2000',
            'page_number' => 'nullable|integer|min:1',
        ]);

        $note->update($validated);

        return redirect()->route('notes.index', $note->book_id)
                         ->with('success', 'Nota actualizada.');
    }

    public function destroy(Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);
        $book_id = $note->book_id;
        $note->delete();

        return redirect()->route('notes.index', $book_id)
                         ->with('success', 'Nota eliminada.');
    }
}