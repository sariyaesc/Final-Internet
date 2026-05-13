<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">➕ Agregar Libro</h2>
            <a href="{{ route('books.index') }}"
               class="text-sm text-blue-600 hover:underline">← Volver al catálogo</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
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

            <form action="{{ route('books.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium mb-1">Título *</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="Ej. El Principito"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                  {{ $errors->has('title') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Autor *</label>
                    <input type="text" name="author" value="{{ old('author') }}"
                           placeholder="Ej. Antoine de Saint-Exupéry"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                  {{ $errors->has('author') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                    @error('author')
                        <p class="text-red-600 text-sm mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-medium mb-1">Total de páginas *</label>
                        <input type="number" name="total_pages" value="{{ old('total_pages') }}"
                               min="1" placeholder="Ej. 200"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                      {{ $errors->has('total_pages') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                        @error('total_pages')
                            <p class="text-red-600 text-sm mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Género</label>
                        <input type="text" name="genre" value="{{ old('genre') }}"
                               placeholder="Ej. Ficción"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}"
                           placeholder="Ej. 978-0156012195"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">URL de portada</label>
                    <input type="url" name="cover_url" value="{{ old('cover_url') }}"
                           placeholder="https://..."
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                  {{ $errors->has('cover_url') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                    @error('cover_url')
                        <p class="text-red-600 text-sm mt-1">⚠️ {{ $message }}</p>
                    @enderror
                    {{-- Preview de portada --}}
                    <div id="cover-preview" class="mt-2 hidden">
                        <img id="preview-img" src="" alt="Preview"
                             class="w-24 h-36 object-cover rounded shadow">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-1">Descripción</label>
                    <textarea name="description" rows="4"
                              placeholder="Breve sinopsis del libro..."
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        💾 Guardar libro
                    </button>
                    <a href="{{ route('books.index') }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview automático de portada al pegar URL --}}
    <script>
        const input   = document.querySelector('input[name="cover_url"]');
        const preview = document.getElementById('cover-preview');
        const img     = document.getElementById('preview-img');

        input.addEventListener('input', function () {
            const url = this.value.trim();
            if (url.startsWith('http')) {
                img.src = url;
                preview.classList.remove('hidden');
                img.onerror = () => preview.classList.add('hidden');
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>