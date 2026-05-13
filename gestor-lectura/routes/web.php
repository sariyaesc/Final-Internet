<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ReadingProgressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Libros — rutas estáticas PRIMERO, dinámicas AL FINAL
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/books/create',      [BookController::class, 'create'])->name('books.create'); // 👈 antes de {book}
        Route::post('/books',            [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}',      [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}',   [BookController::class, 'destroy'])->name('books.destroy');
        Route::get('/users',             [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',      [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',   [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show'); // 👈 al final

    Route::resource('progress', ReadingProgressController::class)->except(['show']);

    Route::resource('notes', NoteController::class)->except(['show']);

require __DIR__ . '/auth.php';
});