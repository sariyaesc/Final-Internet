<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $book->title }}
            </h2>
            <a href="{{ route('books.index') }}"
               class="text-sm text-blue-600 hover:underline">← Volver al catálogo</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 space-y-6">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Info del libro --}}
        <div class="bg-white rounded-lg shadow p-6 flex gap-6">
            @if($book->cover_url)
                <img src="{{ $book->cover_url }}"
                     class="w-36 h-52 object-cover rounded shadow">
            @else
                <div class="w-36 h-52 bg-gray-100 rounded flex items-center justify-center text-5xl">
                    📕
                </div>
            @endif
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-gray-800">{{ $book->title }}</h3>
                <p class="text-gray-600 mt-1">{{ $book->author }}</p>
                <div class="flex gap-3 mt-2 text-sm text-gray-400">
                    @if($book->genre)
                        <span>📂 {{ $book->genre }}</span>
                    @endif
                    <span>📄 {{ $book->total_pages }} páginas</span>
                    @if($book->isbn)
                        <span>ISBN: {{ $book->isbn }}</span>
                    @endif
                </div>
                @if($book->description)
                    <p class="mt-4 text-gray-700 leading-relaxed">{{ $book->description }}</p>
                @endif

                @if(auth()->user()->isAdmin())
                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('books.edit', $book) }}"
                           class="bg-yellow-500 text-white px-4 py-2 rounded text-sm hover:bg-yellow-600 transition">
                            ✏️ Editar
                        </a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este libro?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600 transition">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        {{-- Progreso del usuario --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-bold text-lg text-gray-700 mb-4">📖 Mi progreso</h4>

            @if($progress)
                @php
                    $porcentaje = $book->total_pages > 0
                        ? round($progress->current_page / $book->total_pages * 100)
                        : 0;
                    $statusLabel = [
                        'want_to_read' => '🔖 Por leer',
                        'reading'      => '📖 Leyendo',
                        'completed'    => '✅ Completado',
                    ][$progress->status];
                @endphp

                <div class="flex justify-between items-center mb-2">
                    <span class="font-medium text-gray-700">{{ $statusLabel }}</span>
                    <span class="text-sm text-gray-500">
                        Página {{ $progress->current_page }} / {{ $book->total_pages }}
                    </span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-3 mb-1">
                    <div class="bg-blue-500 h-3 rounded-full transition-all"
                         style="width: {{ $porcentaje }}%"></div>
                </div>
                <p class="text-sm text-blue-600 mb-4">{{ $porcentaje }}% completado</p>

                <a href="{{ route('progress.edit', $progress) }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                    Actualizar progreso
                </a>
            @else
                <p class="text-gray-500 text-sm mb-3">Aún no has agregado este libro a tu lista.</p>
                <a href="{{ route('progress.create') }}?book_id={{ $book->id }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                    + Agregar a mi lista
                </a>
            @endif
        </div>

        {{-- Notas --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-lg text-gray-700">📝 Mis notas</h4>
                <a href="{{ route('notes.create') }}?book_id={{ $book->id }}"
                   class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                    + Nueva nota
                </a>
            </div>

            @forelse($book->notes as $note)
                <div class="border border-gray-200 rounded-lg p-4 mb-3">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            @if($note->page_number)
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
                                    Página {{ $note->page_number }}
                                </span>
                            @endif
                            <p class="text-gray-700 mt-2">{{ $note->content }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $note->created_at->format('d/m/Y H:i') }}
                            </p>
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
                <p class="text-gray-400 text-sm">No tienes notas para este libro aún.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>