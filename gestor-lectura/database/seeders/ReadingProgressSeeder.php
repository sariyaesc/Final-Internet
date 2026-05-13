<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\ReadingProgress;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReadingProgressSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $books = Book::all();

        $statuses = ['want_to_read', 'reading', 'completed'];

        // Cada usuario tiene progreso en al menos 4 libros
        foreach ($users as $index => $user) {
            $userBooks = $books->random(4);

            foreach ($userBooks as $i => $book) {
                $status = $statuses[$i % 3];

                ReadingProgress::create([
                    'user_id'      => $user->id,
                    'book_id'      => $book->id,
                    'status'       => $status,
                    'current_page' => $status === 'completed'
                                        ? $book->total_pages
                                        : rand(1, $book->total_pages),
                    'started_at'   => in_array($status, ['reading', 'completed'])
                                        ? now()->subDays(rand(5, 30))
                                        : null,
                    'finished_at'  => $status === 'completed'
                                        ? now()->subDays(rand(1, 5))
                                        : null,
                ]);
            }
        }
    }
}