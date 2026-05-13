<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // GET /api/books
    public function index()
    {
        $books = Book::with('addedBy:id,name')
                     ->latest()
                     ->get();

        return response()->json([
            'data'    => $books,
            'total'   => $books->count(),
            'message' => 'Libros obtenidos correctamente.',
        ]);
    }

    // GET /api/books/{id}
    public function show(Book $book)
    {
        $book->load('addedBy:id,name');

        return response()->json([
            'data'    => $book,
            'message' => 'Libro obtenido correctamente.',
        ]);
    }

    // POST /api/books
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permiso para agregar libros.',
            ], 403);
        }

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
        $book = Book::create($validated);

        return response()->json([
            'data'    => $book,
            'message' => 'Libro creado correctamente.',
        ], 201);
    }

    // PUT /api/books/{id}
    public function update(Request $request, Book $book)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permiso para editar libros.',
            ], 403);
        }

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'author'      => 'sometimes|required|string|max:255',
            'isbn'        => 'nullable|string|max:20',
            'cover_url'   => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'genre'       => 'nullable|string|max:100',
            'total_pages' => 'sometimes|required|integer|min:1',
        ]);

        $book->update($validated);

        return response()->json([
            'data'    => $book,
            'message' => 'Libro actualizado correctamente.',
        ]);
    }

    // DELETE /api/books/{id}
    public function destroy(Book $book)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permiso para eliminar libros.',
            ], 403);
        }

        $book->delete();

        return response()->json([
            'message' => 'Libro eliminado correctamente.',
        ]);
    }
}