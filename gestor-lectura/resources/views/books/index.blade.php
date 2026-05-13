<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📚 Catálogo de Libros</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->isAdmin())
            <div class="mb-6">
                <a href="{{ route('books.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    + Agregar Libro
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($books as $book)
                <div class="bg-white rounded-lg shadow p-5">
                    @if($book->cover_url)
                        <img src="{{ $book->cover_url }}" alt="Portada"
                             class="w-full h-48 object-cover rounded mb-3">
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded mb-3 flex items-center justify-center text-5xl">
                            📕
                        </div>
                    @endif

                    <h3 class="font-bold text-lg text-gray-800">{{ $book->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $book->author }}</p>
                    <p class="text-gray-400 text-xs mt-1">
                        {{ $book->genre }} · {{ $book->total_pages }} páginas
                    </p>

                    <div class="mt-4 flex gap-3 flex-wrap">
                        <a href="{{ route('books.show', $book) }}"
                           class="text-blue-600 text-sm hover:underline">Ver detalle</a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('books.edit', $book) }}"
                               class="text-yellow-600 text-sm hover:underline">Editar</a>

                            <form action="{{ route('books.destroy', $book) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este libro?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 text-sm hover:underline">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-lg shadow p-10 text-center">
                    <p class="text-5xl mb-3">📭</p>
                    <p class="text-gray-500">No hay libros en el catálogo aún.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $books->links() }}</div>
    </div>
</x-app-layout>