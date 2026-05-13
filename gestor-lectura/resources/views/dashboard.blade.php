<x-app-layout>

    <div class="py-8 max-w-7xl mx-auto px-4 space-y-8">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            ✅ {{ session('success') }}
        </div>
        @endif

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👋 Hola, {{ Auth::user()->name }}
            </h2>
        </x-slot>

        <div class="py-8 max-w-7xl mx-auto px-4 space-y-8">

            {{-- Tarjetas resumen --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
                    <span class="text-4xl">📚</span>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalLibros }}</p>
                        <p class="text-sm text-gray-500">Libros en mi lista</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
                    <span class="text-4xl">📖</span>
                    <div>
                        <p class="text-2xl font-bold text-blue-600">{{ $totalLeyendo }}</p>
                        <p class="text-sm text-gray-500">Leyendo actualmente</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
                    <span class="text-4xl">✅</span>
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $totalCompletados }}</p>
                        <p class="text-sm text-gray-500">Libros completados</p>
                    </div>
                </div>
            </div>

            {{-- Leyendo actualmente --}}
            @if($leyendo->count())
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-3">📖 Leyendo actualmente</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($leyendo as $p)
                    <div class="bg-white rounded-lg shadow p-5">
                        <div class="flex gap-4">
                            @if($p->book->cover_url)
                            <img src="{{ $p->book->cover_url }}"
                                class="w-16 h-24 object-cover rounded">
                            @else
                            <div class="w-16 h-24 bg-gray-200 rounded flex items-center justify-center text-2xl">
                                📕
                            </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $p->book->title }}</p>
                                <p class="text-sm text-gray-500">{{ $p->book->author }}</p>
                                <div class="mt-2">
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>Página {{ $p->current_page }}</span>
                                        <span>{{ $p->book->total_pages }} págs.</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full transition-all"
                                            style="width: {{ $p->book->total_pages > 0 ? round($p->current_page / $p->book->total_pages * 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <p class="text-xs text-blue-600 mt-1">
                                        {{ $p->book->total_pages > 0 ? round($p->current_page / $p->book->total_pages * 100) : 0 }}% completado
                                    </p>
                                </div>
                                <a href="{{ route('progress.edit', $p) }}"
                                    class="text-xs text-blue-600 hover:underline mt-2 inline-block">
                                    Actualizar progreso →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Por leer --}}
            @if($porLeer->count())
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-3">🔖 Próximos a leer</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($porLeer as $p)
                    <div class="bg-white rounded-lg shadow p-4 flex gap-3 items-center">
                        @if($p->book->cover_url)
                        <img src="{{ $p->book->cover_url }}"
                            class="w-12 h-16 object-cover rounded">
                        @else
                        <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xl">
                            📗
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $p->book->title }}</p>
                            <p class="text-xs text-gray-500">{{ $p->book->author }}</p>
                            <a href="{{ route('progress.edit', $p) }}"
                                class="text-xs text-green-600 hover:underline mt-1 inline-block">
                                Empezar a leer →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Completados --}}
            @if($completados->count())
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-3">✅ Completados recientemente</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($completados as $p)
                    <div class="bg-white rounded-lg shadow p-4 flex gap-3 items-center">
                        @if($p->book->cover_url)
                        <img src="{{ $p->book->cover_url }}"
                            class="w-12 h-16 object-cover rounded">
                        @else
                        <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xl">
                            📘
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $p->book->title }}</p>
                            <p class="text-xs text-gray-500">{{ $p->book->author }}</p>
                            @if($p->finished_at)
                            <p class="text-xs text-gray-400 mt-1">
                                Terminado el {{ $p->finished_at->format('d/m/Y') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Si no tiene nada aún --}}
            @if($totalLibros === 0)
            <div class="bg-white rounded-lg shadow p-10 text-center">
                <p class="text-5xl mb-4">📭</p>
                <p class="text-gray-500 text-lg">Aún no tienes libros en tu lista.</p>
                <a href="{{ route('books.index') }}"
                    class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Ver catálogo de libros
                </a>
            </div>
            @endif

        </div>
</x-app-layout>