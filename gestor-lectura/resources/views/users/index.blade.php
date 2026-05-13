<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">👥 Gestión de Usuarios</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">#</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Nombre</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Email</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Rol</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Registrado</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-400">{{ $user->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $user->name }}
                                @if($user->id === Auth::id())
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full ml-1">Tú</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full font-medium">
                                        👑 Admin
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full font-medium">
                                        👤 Usuario
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->id !== Auth::id())
                                    <div class="flex gap-2">
                                        <a href="{{ route('users.edit', $user) }}"
                                           class="text-blue-600 hover:underline text-xs">
                                            Cambiar rol
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar a {{ $user->name }}?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline text-xs">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 border-t">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>