<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">✏️ Editar Libro</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('books.update', $book) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">Título *</label>
                    <input type="text" name="title"
                           value="{{ old('title', $book->title) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                  {{ $errors->has('title') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Autor *</label>
                    <input type="text" name="author"
                           value="{{ old('author', $book->author) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                  {{ $errors->has('author') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                    @error('author')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-medium mb-1">ISBN</label>
                        <input type="text" name="isbn"
                               value="{{ old('isbn', $book->isbn) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Total de páginas *</label>
                        <input type="number" name="total_pages"
                               value="{{ old('total_pages', $book->total_pages) }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                      {{ $errors->has('total_pages') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                        @error('total_pages')
                            <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Género</label>
                    <input type="text" name="genre"
                           value="{{ old('genre', $book->genre) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">URL de portada</label>
                    <input type="url" name="cover_url"
                           value="{{ old('cover_url', $book->cover_url) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                  {{ $errors->has('cover_url') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                    @error('cover_url')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-1">Descripción</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $book->description) }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        💾 Guardar cambios
                    </button>
                    <a href="{{ route('books.show', $book) }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>