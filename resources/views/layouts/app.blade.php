<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaon Ta! Davao – Diaz's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-orange-50 text-gray-800 min-h-screen flex flex-col">
    <header class="bg-orange-700 text-white">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <a href="{{ route('home') }}" class="text-xl font-bold">Kaon Ta! Davao – Diaz's Food Guide</a>
            @include('partials.nav')
        </div>
    </header>

    <main class="max-w-6xl w-full mx-auto px-4 py-6 flex-1">
        @include('partials.flash')

        @yield('content')
    </main>

    <footer class="text-center text-sm text-gray-500 py-4">
        Kaon Ta! Davao &middot; CS Elective 2 Prefinal Project
    </footer>
</body>
</html>
