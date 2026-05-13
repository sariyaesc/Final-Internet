<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\ReadingProgress;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $notas = [
            'Este capítulo me hizo reflexionar mucho sobre la vida.',
            'Excelente metáfora del autor en esta parte.',
            'No entendí bien este fragmento, releerlo después.',
            'Cita favorita de este libro hasta ahora.',
            'El personaje principal cambia mucho aquí.',
            'La descripción del lugar es increíble.',
            'Recordar esta idea para aplicarla en la vida real.',
            'El giro de la trama no me lo esperaba.',
            'Muy buen ritmo narrativo en estos capítulos.',
            'El autor conecta perfectamente las ideas.',
        ];

        // Crear notas basadas en el progreso existente
        $progressList = ReadingProgress::whereIn('status', ['reading', 'completed'])
                                       ->get();

        foreach ($progressList as $progress) {
            $cantNotas = rand(1, 3);
            for ($i = 0; $i < $cantNotas; $i++) {
                Note::create([
                    'user_id'     => $progress->user_id,
                    'book_id'     => $progress->book_id,
                    'content'     => $notas[array_rand($notas)],
                    'page_number' => rand(1, 50),
                ]);
            }
        }
    }
}