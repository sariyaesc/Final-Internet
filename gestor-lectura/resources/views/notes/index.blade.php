<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">📝 Mis Notas</h2>
            <a href="{{ route('notes.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm">
                + Nueva nota
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Filtro por libro --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('notes.index') }}" class="flex gap-3 items-end flex-wrap">
                <div class="flex-1 min-w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Filtrar por libro
                    </label>
                    <select name="book_id"
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">— Todos los libros —</option>
                        @foreach($misLibros as $libro)
                            <option value="{{ $libro->id }}"
                                {{ request('book_id') == $libro->id ? 'selected' : '' }}>
                                {{ $libro->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                    Filtrar
                </button>
                @if(request('book_id'))
                    <a href="{{ route('notes.index') }}"
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition text-sm">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        {{-- Lista de notas --}}
        @forelse($notes as $note)
            <div class="bg-white rounded-lg shadow p-5 mb-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">

                        {{-- Libro relacionado --}}
                        <div class="flex items-center gap-2 mb-2">
                            @if($note->book->cover_url)
                                <img src="{{ $note->book->cover_url }}"
                                     class="w-8 h-10 object-cover rounded">
                            @endif
                            <div>
                                <a href="{{ route('books.show', $note->book) }}"
                                   class="text-sm font-semibold text-blue-600 hover:underline">
                                    {{ $note->book->title }}
                                </a>
                                <p class="text-xs text-gray-400">{{ $note->book->author }}</p>
                            </div>
                        </div>

                        {{-- Contenido de la nota --}}
                        @if($note->page_number)
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
                                Página {{ $note->page_number }}
                            </span>
                        @endif
                        <p class="text-gray-800 mt-2">{{ $note->content }}</p>
                        <p class="text-xs text-gray-400 mt-2">
                            🕐 {{ $note->created_at->diffForHumans() }}
                            — {{ $note->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    {{-- Acciones --}}
                    <div class="flex flex-col gap-2 ml-4">
                        <a href="{{ route('notes.edit', $note) }}"
                           class="text-yellow-600 text-sm hover:underline text-right">Editar</a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta nota?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm hover:underline">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-10 text-center">
                <p class="text-4xl mb-3">📭</p>
                <p class="text-gray-500">
                    @if(request('book_id'))
                        No tienes notas para este libro.
                    @else
                        No tienes notas aún.
                    @endif
                </p>
                <a href="{{ route('notes.create') }}"
                   class="inline-block mt-3 text-green-600 hover:underline text-sm">
                    Escribe tu primera nota
                </a>
            </div>
        @endforelse

    </div>
</x-app-layout>