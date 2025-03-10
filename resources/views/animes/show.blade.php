@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Anime Image -->
                <div class="md:w-1/3">
                    <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}" class="w-full h-auto object-cover">
                </div>

                <!-- Anime Details -->
                <div class="md:w-2/3 p-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $anime->title }}</h1>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="col-span-1">
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Status:</span>
                                <span
                                    class="px-2 py-1 rounded {{ $anime->airing ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $anime->status }}
                                </span>
                            </p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Episodes:</span> {{ $anime->episodes ?? 'Unknown' }}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Year:</span> {{ $anime->year ?? 'Unknown' }}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Rating:</span> {{ $anime->rating ?? 'Not Rated' }}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Score:</span>
                                <span class="text-yellow-500">★</span> {{ number_format($anime->score, 1) ?? 'N/A' }}/10
                            </p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Synopsis</h2>
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ $anime->synopsis ?? 'No synopsis available.' }}
                        </p>
                    </div>

                    <div class="flex space-x-4">
                        <a href="{{ route('animes.index') }}"
                            class="px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                            Back to List
                        </a>
                        <button type="button"
                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Purple</button>
                        <a href="{{ route('animes.index') }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            Return to Index
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
