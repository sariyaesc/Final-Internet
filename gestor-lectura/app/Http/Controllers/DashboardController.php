<?php

namespace App\Http\Controllers;

use App\Models\ReadingProgress;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $leyendo = ReadingProgress::with('book')
            ->where('user_id', $userId)
            ->where('status', 'reading')
            ->latest()
            ->get();

        $porLeer = ReadingProgress::with('book')
            ->where('user_id', $userId)
            ->where('status', 'want_to_read')
            ->latest()
            ->take(5)
            ->get();

        $completados = ReadingProgress::with('book')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        $totalLibros     = $leyendo->count() + $porLeer->count() + $completados->count();
        $totalCompletados = $completados->count();
        $totalLeyendo     = $leyendo->count();

        return view('dashboard', compact(
            'leyendo', 'porLeer', 'completados',
            'totalLibros', 'totalCompletados', 'totalLeyendo'
        ));
    }
}