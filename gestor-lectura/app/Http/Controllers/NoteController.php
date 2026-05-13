<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Libros que el usuario tiene en su progreso
        $misLibros = \App\Models\ReadingProgress::with('book')
            ->where('user_id', $userId)
            ->get()
            ->pluck('book');

        $query = Note::with('book')
            ->where('user_id', $userId)
            ->latest();

        // Filtro por libro
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        $notes = $query->get();

        return view('notes.index', compact('notes', 'misLibros'));
    }

    public function create(Request $request)
    {
        // Solo libros que el usuario está leyendo actualmente
        $books = \App\Models\ReadingProgress::with('book')
            ->where('user_id', Auth::id())
            ->where('status', 'reading')
            ->get()
            ->pluck('book');

        $selectedBookId = $request->book_id;

        return view('notes.create', compact('books', 'selectedBookId'));
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

        return redirect()->route('notes.index')
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
