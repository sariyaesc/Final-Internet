<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $books = [
            [
                'title'       => 'El Principito',
                'author'      => 'Antoine de Saint-Exupéry',
                'isbn'        => '978-0156012195',
                'genre'       => 'Ficción',
                'total_pages' => 96,
                'description' => 'Un piloto que cae en el desierto conoce a un pequeño príncipe venido de otro planeta.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780156012195-L.jpg',
            ],
            [
                'title'       => 'Cien años de soledad',
                'author'      => 'Gabriel García Márquez',
                'isbn'        => '978-0307474728',
                'genre'       => 'Realismo mágico',
                'total_pages' => 417,
                'description' => 'La historia de la familia Buendía a lo largo de siete generaciones en Macondo.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780307474728-L.jpg',
            ],
            [
                'title'       => '1984',
                'author'      => 'George Orwell',
                'isbn'        => '978-0451524935',
                'genre'       => 'Distopía',
                'total_pages' => 328,
                'description' => 'Una sociedad totalitaria donde el Gran Hermano todo lo vigila.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg',
            ],
            [
                'title'       => 'Harry Potter y la piedra filosofal',
                'author'      => 'J.K. Rowling',
                'isbn'        => '978-0439708180',
                'genre'       => 'Fantasía',
                'total_pages' => 309,
                'description' => 'Un niño descubre que es un mago y asiste a la escuela Hogwarts.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780439708180-L.jpg',
            ],
            [
                'title'       => 'Don Quijote de la Mancha',
                'author'      => 'Miguel de Cervantes',
                'isbn'        => '978-8420412146',
                'genre'       => 'Clásico',
                'total_pages' => 863,
                'description' => 'Las aventuras del ingenioso hidalgo Don Quijote y su fiel escudero Sancho Panza.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9788420412146-L.jpg',
            ],
            [
                'title'       => 'El alquimista',
                'author'      => 'Paulo Coelho',
                'isbn'        => '978-0062315007',
                'genre'       => 'Ficción filosófica',
                'total_pages' => 197,
                'description' => 'Un pastor andaluz viaja en busca de un tesoro y descubre el significado de la vida.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780062315007-L.jpg',
            ],
            [
                'title'       => 'Sapiens',
                'author'      => 'Yuval Noah Harari',
                'isbn'        => '978-0062316097',
                'genre'       => 'No ficción',
                'total_pages' => 443,
                'description' => 'Una breve historia de la humanidad desde los primeros humanos hasta la actualidad.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg',
            ],
            [
                'title'       => 'Atomic Habits',
                'author'      => 'James Clear',
                'isbn'        => '978-0735211292',
                'genre'       => 'Desarrollo personal',
                'total_pages' => 320,
                'description' => 'Cómo construir buenos hábitos y eliminar los malos con pequeños cambios.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780735211292-L.jpg',
            ],
            [
                'title'       => 'Clean Code',
                'author'      => 'Robert C. Martin',
                'isbn'        => '978-0132350884',
                'genre'       => 'Tecnología',
                'total_pages' => 431,
                'description' => 'Guía para escribir código limpio, legible y mantenible.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780132350884-L.jpg',
            ],
            [
                'title'       => 'El nombre del viento',
                'author'      => 'Patrick Rothfuss',
                'isbn'        => '978-0756404741',
                'genre'       => 'Fantasía épica',
                'total_pages' => 662,
                'description' => 'La historia de Kvothe, un legendario mago y músico, narrada por él mismo.',
                'cover_url'   => 'https://covers.openlibrary.org/b/isbn/9780756404741-L.jpg',
            ],
        ];

        foreach ($books as $book) {
            Book::create(array_merge($book, ['added_by' => $admin->id]));
        }
    }
}