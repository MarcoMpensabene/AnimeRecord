@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center"
        style="background-image: url('https://itsaboutanime.wordpress.com/wp-content/uploads/2019/12/4k-anime-wallpapers-top-free-4k-anime-backgrounds.jpg');">
        <div class="max-w-7xl mx-auto p-6 min-h-[80vh] flex items-start">
            <div class="bg-black dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden w-full p-6 flex flex-col">

                <div class="flex flex-col md:flex-row">
                    <!-- Anime Image -->
                    <div class="md:w-1/3 flex justify-center">
                        <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}"
                            class="w-full max-w-[250px] h-auto object-cover rounded-lg">
                    </div>

                    <!-- Anime Details -->
                    <div class="md:w-2/3 md:pl-6 mt-4 md:mt-0 flex flex-col">
                        <h1 class="text-3xl font-bold text-blue-900 dark:text-white mb-4">{{ $anime->title }}</h1>

                        <div class="space-y-2">
                            <p class="text-white dark:text-white">
                                <span class="font-semibold">Status:</span>
                                <span
                                    class="px-2 py-1 rounded {{ $anime->airing ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $anime->status }}
                                </span>
                            </p>
                            <p class="text-white dark:text-gray-300">
                                <span class="font-semibold">Episodes:</span> {{ $anime->episodes ?? 'Unknown' }}
                            </p>
                            <p class="text-white dark:text-gray-300">
                                <span class="font-semibold">Year:</span> {{ $anime->year ?? 'Unknown' }}
                            </p>
                            <p class="text-white dark:text-gray-300">
                                <span class="font-semibold">Rating:</span> {{ $anime->rating ?? 'Not Rated' }}
                            </p>
                            <p class="text-white dark:text-gray-300">
                                <span class="font-semibold">Score:</span>
                                <span class="text-yellow-500">★</span> {{ number_format($anime->score, 1) ?? 'N/A' }}/10
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Synopsis & Links -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-blue-900 dark:text-white mb-2">Synopsis</h2>
                    <p class="text-white dark:text-gray-300 mb-4">
                        {{ $anime->synopsis ?? 'No synopsis available.' }}
                    </p>

                    <!-- Fake Links -->
                    <div class="mt-4 border-t pt-4">
                        <h3 class="text-lg font-semibold text-green-900 dark:text-white mb-2">Related Test Links</h3>
                        <ul class="text-indigo-500 dark:text-indigo-400 space-y-2">
                            <li><a href="#" class="hover:underline">Official Website</a></li>
                            <li><a href="#" class="hover:underline">MAL Page</a></li>
                            <li><a href="#" class="hover:underline">Wikipedia</a></li>
                            <li><a href="#" class="hover:underline">Fan Community</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('animes.index') }}"
                        class="px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200 shadow-md hover:shadow-lg ">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
