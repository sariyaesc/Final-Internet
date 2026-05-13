<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📝 Mis notas — {{ $book->title }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('books.show', $book) }}"
               class="text-blue-600 hover:underline text-sm">← Volver al libro</a>
            <a href="{{ route('notes.create') }}?book_id={{ $book->id }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm transition">
                + Nueva nota
            </a>
        </div>

        @forelse($notes as $note)
            <div class="bg-white rounded-lg shadow p-5 mb-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        @if($note->page_number)
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full mb-2 inline-block">
                                Página {{ $note->page_number }}
                            </span>
                        @endif
                        <p class="text-gray-800 mt-1">{{ $note->content }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $note->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <a href="{{ route('notes.edit', $note) }}"
                           class="text-yellow-600 text-sm hover:underline">Editar</a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta nota?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm hover:underline">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-400">
                <p class="text-4xl mb-2">📭</p>
                <p>No tienes notas para este libro aún.</p>
                <a href="{{ route('notes.create') }}?book_id={{ $book->id }}"
                   class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                    Escribe tu primera nota
                </a>
            </div>
        @endforelse
    </div>
</x-app-layout>