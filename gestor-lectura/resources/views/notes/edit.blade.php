<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">✏️ Editar Nota</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6">

            @if($errors->any())
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <p class="font-semibold">⚠️ Corrige los siguientes errores:</p>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4 p-3 bg-gray-50 rounded border border-gray-200">
                <p class="text-sm text-gray-600">
                    📚 Libro: <strong>{{ $note->book->title }}</strong>
                </p>
            </div>

            <form action="{{ route('notes.update', $note) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">Página (opcional)</label>
                    <input type="number" name="page_number"
                           value="{{ old('page_number', $note->page_number) }}" min="1"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-1">Nota *</label>
                    <textarea name="content" rows="5"
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                     {{ $errors->has('content') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">{{ old('content', $note->content) }}</textarea>
                    @error('content')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                        💾 Guardar cambios
                    </button>
                    <a href="{{ route('notes.index', $note->book_id) }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>