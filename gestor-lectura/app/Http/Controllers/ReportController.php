<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReadingProgress;
use App\Models\Book;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->is_admin;

        $query = ReadingProgress::with(['book', 'user'])->latest();

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('genre')) {
            $query->whereHas('book', function ($q) use ($request) {
                $q->where('genre', $request->input('genre'));
            });
        }

        $records = $query->get();
        $genres = Book::whereNotNull('genre')->distinct()->pluck('genre');

        return view('report', [
            'records' => $records,
            'genres' => $genres,
            'isAdmin' => $isAdmin,
            'user' => $user,
            'filters' => [
                'status' => $request->input('status'),
                'genre' => $request->input('genre'),
            ],
        ]);
    }
}
