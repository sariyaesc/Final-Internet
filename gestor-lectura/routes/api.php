<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login',    [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::get('/books',           [BookController::class, 'index'])->name('api.books.index');
    Route::post('/books',          [BookController::class, 'store'])->name('api.books.store');
    Route::get('/books/{book}',    [BookController::class, 'show'])->name('api.books.show');
    Route::put('/books/{book}',    [BookController::class, 'update'])->name('api.books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('api.books.destroy');
});