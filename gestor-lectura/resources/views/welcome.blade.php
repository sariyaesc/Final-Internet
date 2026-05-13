<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Lecturas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-2xl">📚</span>
            <span class="font-bold text-gray-800 text-lg">Gestor de Lecturas</span>
        </div> 
    </nav>

    {{-- Hero --}}
    <div class="max-w-5xl mx-auto px-6 py-20 text-center">
        <p class="text-6xl mb-6">📖</p>
        <h1 class="text-4xl font-bold text-gray-800 mb-4">
            Tu biblioteca personal
        </h1>
        <p class="text-gray-500 text-lg max-w-xl mx-auto mb-10">
            Lleva el control de tus lecturas, registra tu progreso y guarda notas de tus libros favoritos.
        </p>
        <div class="flex gap-4 justify-center">
            <a href="{{ route('register') }}"
               class="bg-blue-600 text-white px-8 py-3 rounded-lg text-base font-medium hover:bg-blue-700 transition">
                Crear cuenta gratis
            </a>
            <a href="{{ route('login') }}"
               class="bg-white border border-gray-300 text-gray-700 px-8 py-3 rounded-lg text-base font-medium hover:bg-gray-50 transition">
                Ya tengo cuenta
            </a>
        </div>
    </div>

    {{-- Features --}}
    <div class="max-w-5xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-4xl mb-3">📚</p>
                <h3 class="font-semibold text-gray-800 mb-2">Catálogo de libros</h3>
                <p class="text-gray-500 text-sm">Explora y agrega libros a tu lista de lectura personal.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-4xl mb-3">📊</p>
                <h3 class="font-semibold text-gray-800 mb-2">Seguimiento de progreso</h3>
                <p class="text-gray-500 text-sm">Registra en qué página vas y visualiza tu avance.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-4xl mb-3">📝</p>
                <h3 class="font-semibold text-gray-800 mb-2">Notas personales</h3>
                <p class="text-gray-500 text-sm">Guarda tus reflexiones y citas favoritas de cada libro.</p>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="text-center text-gray-400 text-sm pb-8">
        Gestor de Lecturas · Programación para Internet II
    </footer>

</body>
</html>