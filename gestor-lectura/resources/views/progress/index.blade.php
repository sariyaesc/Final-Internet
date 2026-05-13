<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">📖 Mi Progreso de Lectura</h2>
	</x-slot>

	<div class="py-8 max-w-7xl mx-auto px-4">
		@if($progress->isEmpty())
			<div class="bg-white rounded-lg shadow p-10 text-center">
				<p class="text-5xl mb-3">📭</p>
				<p class="text-gray-500">No tienes libros en progreso aún.</p>
			</div>
		@else
			@if(isset($progress['reading']) && $progress['reading']->count())
				<h3 class="text-lg font-bold text-gray-700 mb-4">Leyendo</h3>
				<div class="grid grid-cols-2 gap-6">
					@foreach($progress['reading'] as $item)
						<div class="bg-white rounded-lg shadow p-5 flex items-center gap-6">
							<div class="flex-shrink-0 mr-4 h-36 flex items-center">
								@if($item->book->cover_url)
									<img src="{{ $item->book->cover_url }}" alt="Portada" class="h-40 w-auto max-w-[96px] rounded shadow-sm bg-white p-1">
								@else
									<div class="h-32 w-20 bg-gray-100 rounded flex items-center justify-center text-3xl">📕</div>
								@endif
							</div>
							<div class="flex-1">
								<h4 class="font-bold text-lg text-gray-800">{{ $item->book->title }}</h4>
								<p class="text-gray-600 text-sm mb-1">{{ $item->book->author }}</p>
								<p class="text-gray-400 text-xs mb-2">{{ $item->book->genre }} · {{ $item->book->total_pages }} páginas</p>
								<div class="text-sm mb-2">
									<span class="font-semibold">Página actual:</span> {{ $item->current_page }}<br>
									<span class="font-semibold">Iniciado:</span> {{ optional($item->started_at)->format('d/m/Y') ?? '-' }}<br>
									<span class="font-semibold">Progreso:</span> 
									@if($item->book->total_pages > 0)
										{{ round(($item->current_page / $item->book->total_pages) * 100, 1) }}%
									@else
										-
									@endif
								</div>
								<div class="flex gap-3 items-center mt-4">
									<a href="{{ route('books.show', $item->book) }}" class="text-blue-600 text-sm hover:underline">Ver libro</a>
									<a href="{{ route('progress.edit', $item) }}" class="bg-yellow-500 text-white px-6 py-1.5 rounded text-sm font-semibold hover:bg-yellow-600 transition whitespace-nowrap">Actualizar progreso</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		@endif
	</div>
</x-app-layout>
