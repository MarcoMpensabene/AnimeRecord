@extends('layouts.app')

@section('title', 'Search Anime')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <!-- Search Form -->
                <form action="{{ route('animes.index') }}" method="GET" class="space-y-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Search Anime</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Genre Filter -->
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">
                                Genre
                            </label>
                            <select name="genre" id="genre"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                                <option value="">All Genres</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Year Filter -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                                Year
                            </label>
                            <select name="year" id="year"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                                <option value="">All Years</option>
                                @foreach ($years as $year)
                                    @if ($year)
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Search Anime
                        </button>
                    </div>
                </form>

                <!-- Results Section -->
                @if (isset($animeData) && $animeData->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Search Results</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($animeData as $anime)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                    @if ($anime->image_url)
                                        <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}"
                                            class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-4">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $anime->title }}</h4>
                                        <p class="text-sm text-gray-600 mb-2">Year: {{ $anime->year ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600 mb-4">Score: {{ $anime->score ?? 'N/A' }}</p>
                                        <a href="{{ route('animes.show', $anime->id) }}"
                                            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $animeData->links() }}
                        </div>
                    </div>
                @elseif(isset($animeData))
                    <div class="mt-8 text-center text-gray-500">
                        No anime found matching your criteria.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
