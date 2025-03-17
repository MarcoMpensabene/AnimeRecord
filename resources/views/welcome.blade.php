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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .seasonal-anime-swiper {
            position: relative;
            padding: 0 40px;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #4F46E5;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px;
        }

        .swiper-button-next {
            right: 0;
        }

        .swiper-button-prev {
            left: 0;
        }

        .swiper-pagination-bullet-active {
            background: #4F46E5;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white flex flex-col items-center min-h-screen">
    <header class="w-full p-4 flex justify-between items-center bg-white dark:bg-gray-800 shadow">
        <h1 class="text-xl font-bold">AnimeRecord</h1>
        <a href="{{ route('animes.index') }}"
            class="flex px-4 py-2 bg-blue-500 text-white rounded hover:bg-red-600">Anime
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

        <!-- Seasonal Anime Carousel -->
        <div class="w-full max-w-4xl mb-8">
            <h3 class="text-2xl font-bold mb-4">Current Season Anime</h3>
            <div class="swiper seasonal-anime-swiper">
                <div class="swiper-wrapper" id="seasonal-anime-container">
                    <!-- Anime cards will be inserted here -->
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <a href="{{ route('register') }}"
            class="px-6 py-3 bg-indigo-600 text-white rounded-lg text-lg hover:bg-indigo-700">
            Get Started
        </a>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper
            const swiper = new Swiper('.seasonal-anime-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                }
            });

            // Fetch seasonal anime
            fetch('{{ route('seasonal.anime') }}')
                .then(response => response.json())
                .then(animeList => {
                    const container = document.getElementById('seasonal-anime-container');
                    animeList.forEach(anime => {
                        const slide = document.createElement('div');
                        slide.className = 'swiper-slide';
                        slide.innerHTML = `
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden h-full">
                                <div class="relative">
                                    <img src="${anime.image_url}" alt="${anime.title}" class="w-full h-64 object-cover">
                                    ${anime.airing ? '<span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-sm">Airing</span>' : ''}
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-lg mb-2 line-clamp-2">${anime.title}</h4>
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        ${anime.genres.map(genre => `<span class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-100 text-xs px-2 py-1 rounded">${genre}</span>`).join('')}
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            ${anime.score}
                                        </span>
                                        <span>${anime.episodes} eps</span>
                                        <span>${anime.status}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">${anime.synopsis}</p>
                                </div>
                            </div>
                        `;
                        container.appendChild(slide);
                    });
                })
                .catch(error => console.error('Error fetching seasonal anime:', error));
        });
    </script>
</body>

</html>
