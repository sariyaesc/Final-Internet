<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReadingProgressController extends Controller
{
    public function index()
    {
        $progress = ReadingProgress::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->groupBy('status');

        return view('progress.index', compact('progress'));
    }

    public function create()
    {
        $books = Book::all();
        return view('progress.create', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id'      => 'required|exists:books,id',
            'status'       => 'required|in:want_to_read,reading,completed',
            'current_page' => 'required|integer|min:0',
        ]);

        $book = \App\Models\Book::find($validated['book_id']);

        // Lógica automática de status según páginas
        $validated['status'] = $this->calcularStatus(
            $validated['current_page'],
            $book->total_pages,
            $validated['status']
        );

        $validated['user_id']    = Auth::id();
        $validated['started_at'] = in_array($validated['status'], ['reading', 'completed'])
            ? now() : null;
        $validated['finished_at'] = $validated['status'] === 'completed'
            ? now() : null;

        ReadingProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $validated['book_id']],
            $validated
        );

        return redirect()->route('dashboard')
            ->with('success', 'Progreso guardado.');
    }

    public function edit(ReadingProgress $progress)
    {
        abort_if($progress->user_id !== Auth::id(), 403);

        $books = Book::all();
        return view('progress.edit', compact('progress', 'books'));
    }

    public function update(Request $request, ReadingProgress $progress)
    {
        abort_if($progress->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'status'       => 'required|in:want_to_read,reading,completed',
            'current_page' => 'required|integer|min:0',
        ]);

        // Lógica automática de status según páginas
        $validated['status'] = $this->calcularStatus(
            $validated['current_page'],
            $progress->book->total_pages,
            $validated['status']
        );

        if (in_array($validated['status'], ['reading', 'completed']) && !$progress->started_at) {
            $validated['started_at'] = now();
        }
        if ($validated['status'] === 'completed' && !$progress->finished_at) {
            $validated['finished_at'] = now();
        }
        // Si regresa a want_to_read, limpia fechas
        if ($validated['status'] === 'want_to_read') {
            $validated['started_at']  = null;
            $validated['finished_at'] = null;
        }

        $progress->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Progreso actualizado.');
    }

    public function destroy(ReadingProgress $progress)
    {
        abort_if($progress->user_id !== Auth::id(), 403);
        $progress->delete();

        return redirect()->route('progress.index')
            ->with('success', 'Progreso eliminado.');
    }

    private function calcularStatus(int $currentPage, int $totalPages, string $statusElegido): string
    {
        if ($currentPage === 0) {
            return 'want_to_read';
        }

        if ($totalPages > 0 && $currentPage >= $totalPages) {
            return 'completed';
        }

        if ($currentPage > 0) {
            return 'reading';
        }

        return $statusElegido;
    }
}
