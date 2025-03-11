@php
    use Illuminate\Support\Facades\Route;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AnimeRecord</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white flex flex-col items-center min-h-screen">
    <header class="w-full p-4 flex justify-between items-center bg-white dark:bg-gray-800 shadow">
        <h1 class="text-xl font-bold">AnimeRecord</h1>
        <a href="{{ route('animes.index') }}" class="flex px-4 py-2 bg-blue-500 text-white rounded hover:bg-red-600">Anime
            List</a>
        <a href="{{ route('animes.search') }}"
            class="flex px-4 py-2 bg-green-500 text-white rounded hover:bg-red-600">Anime
            Search</a>
        <nav>

            @if (Route::has('login'))
                <div class="flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 border rounded hover:bg-gray-200 dark:hover:bg-gray-700">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>
    </header>

    <main class="flex flex-col items-center justify-center flex-1 text-center p-6">
        <h2 class="text-3xl font-bold mb-4">Welcome to AnimeRecord</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">Track, rate, and discover anime with ease.</p>
        <a href="{{ route('register') }}"
            class="px-6 py-3 bg-indigo-600 text-white rounded-lg text-lg hover:bg-indigo-700">
            Get Started
        </a>
    </main>
</body>

</html>
