<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📖 Agregar libro a mi lista</h2>
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

            <form action="{{ route('progress.store') }}" method="POST">
                @csrf

                {{-- Input oculto de página --}}
                <input type="hidden" name="current_page" id="current_page_input" value="0">
                {{-- Input oculto de status --}}
                <input type="hidden" name="status" id="status_input" value="want_to_read">

                <div class="mb-4">
                    <label class="block font-medium mb-1">Libro *</label>
                    <select name="book_id" id="book_select"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400
                                   {{ $errors->has('book_id') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                        <option value="">— Selecciona un libro —</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}"
                                    data-pages="{{ $book->total_pages }}"
                                {{ old('book_id', request('book_id')) == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} — {{ $book->author }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <p class="text-red-600 text-sm mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-3">Estado *</label>
                    <div class="grid grid-cols-3 gap-3">

                        <label class="cursor-pointer">
                            <input type="radio" name="_status" value="want_to_read"
                                   class="hidden status-radio" checked>
                            <div class="status-btn p-3 border-2 border-blue-500 bg-blue-50 rounded-lg text-center transition">
                                <p class="text-2xl">🔖</p>
                                <p class="text-xs font-medium mt-1">Por leer</p>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="_status" value="reading"
                                   class="hidden status-radio">
                            <div class="status-btn p-3 border-2 border-gray-200 rounded-lg text-center transition">
                                <p class="text-2xl">📖</p>
                                <p class="text-xs font-medium mt-1">Leyendo</p>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="_status" value="completed"
                                   class="hidden status-radio">
                            <div class="status-btn p-3 border-2 border-gray-200 rounded-lg text-center transition">
                                <p class="text-2xl">✅</p>
                                <p class="text-xs font-medium mt-1">Completado</p>
                            </div>
                        </label>

                    </div>
                </div>

                {{-- Campo de páginas — solo visible cuando status = reading --}}
                <div id="pages-section" class="mb-6 hidden">
                    <label class="block font-medium mb-1">
                        Página actual
                        <span class="text-gray-400 font-normal text-sm" id="max-pages-label"></span>
                    </label>
                    <input type="number" id="pages-input"
                           value="0" min="0"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Guardar
                    </button>
                    <a href="{{ route('dashboard') }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const radios       = document.querySelectorAll('.status-radio');
        const statusInput  = document.getElementById('status_input');
        const hiddenInput  = document.getElementById('current_page_input');
        const pagesSection = document.getElementById('pages-section');
        const pagesInput   = document.getElementById('pages-input');
        const bookSelect   = document.getElementById('book_select');
        const maxLabel     = document.getElementById('max-pages-label');
        const statusBtns   = document.querySelectorAll('.status-btn');

        function getTotalPages() {
            const opt = bookSelect.options[bookSelect.selectedIndex];
            return parseInt(opt?.dataset?.pages || 0);
        }

        function updateUI(status) {
            const total = getTotalPages();

            // Resetear estilos
            statusBtns.forEach(btn => {
                btn.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50');
                btn.classList.add('border-gray-200');
            });

            // Resaltar seleccionado
            const selectedBtn = document.querySelector(`input[value="${status}"]`)
                                        .parentElement.querySelector('.status-btn');
            selectedBtn.classList.remove('border-gray-200');
            if (status === 'completed') {
                selectedBtn.classList.add('border-green-500', 'bg-green-50');
            } else {
                selectedBtn.classList.add('border-blue-500', 'bg-blue-50');
            }

            // Mostrar/ocultar páginas y setear valor oculto
            if (status === 'reading') {
                pagesSection.classList.remove('hidden');
                maxLabel.textContent = total > 0 ? `(máx. ${total})` : '';
                pagesInput.max       = total;
                hiddenInput.value    = pagesInput.value;
            } else if (status === 'want_to_read') {
                pagesSection.classList.add('hidden');
                hiddenInput.value = 0;
            } else if (status === 'completed') {
                pagesSection.classList.add('hidden');
                hiddenInput.value = total;
            }

            statusInput.value = status;
        }

        radios.forEach(radio => {
            radio.addEventListener('change', () => updateUI(radio.value));
        });

        pagesInput.addEventListener('input', () => {
            hiddenInput.value = pagesInput.value;
        });

        bookSelect.addEventListener('change', () => {
            const current = document.querySelector('.status-radio:checked');
            if (current) updateUI(current.value);
        });

        // Inicializar
        updateUI('want_to_read');
    </script>
</x-app-layout>