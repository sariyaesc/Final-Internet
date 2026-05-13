<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ Cambiar rol — {{ $user->name }}
            </h2>
            <a href="{{ route('users.index') }}"
               class="text-sm text-blue-600 hover:underline">← Volver a usuarios</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-md mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6">

            <div class="mb-6 p-4 bg-gray-50 rounded border border-gray-200">
                <p class="text-sm text-gray-600">
                    👤 <strong>{{ $user->name }}</strong>
                </p>
                <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                <p class="text-sm mt-1">
                    Rol actual:
                    <span class="{{ $user->role === 'admin' ? 'text-purple-600' : 'text-gray-600' }} font-medium">
                        {{ $user->role === 'admin' ? '👑 Admin' : '👤 Usuario' }}
                    </span>
                </p>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block font-medium mb-2">Nuevo rol *</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 border rounded cursor-pointer hover:bg-gray-50
                                      {{ old('role', $user->role) === 'user' ? 'border-blue-400 bg-blue-50' : 'border-gray-200' }}">
                            <input type="radio" name="role" value="user"
                                   {{ old('role', $user->role) === 'user' ? 'checked' : '' }}>
                            <span>👤 Usuario — acceso básico</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 border rounded cursor-pointer hover:bg-gray-50
                                      {{ old('role', $user->role) === 'admin' ? 'border-purple-400 bg-purple-50' : 'border-gray-200' }}">
                            <input type="radio" name="role" value="admin"
                                   {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}>
                            <span>👑 Admin — acceso completo</span>
                        </label>
                    </div>
                    @error('role')
                        <p class="text-red-600 text-sm mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        💾 Guardar cambio
                    </button>
                    <a href="{{ route('users.index') }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>