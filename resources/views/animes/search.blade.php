@extends('layouts.app')

@section('title', 'Search Anime')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center"
        style="background-image: url('https://itsaboutanime.wordpress.com/wp-content/uploads/2019/12/4k-anime-wallpapers-top-free-4k-anime-backgrounds.jpg');">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-green-100 rounded-lg shadow-sm p-6">
                    <!-- Search Form -->
                    <form action="{{ route('animes.search') }}" method="GET" class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Search Anime</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Genre Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Genre
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach ($genres as $genre)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="genre[]" value="{{ $genre }}"
                                                id="genre_{{ $genre }}"
                                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                {{ is_array(request('genre')) && in_array($genre, request('genre')) ? 'checked' : '' }}>
                                            <label for="genre_{{ $genre }}"
                                                class="ml-2 text-sm text-blue-700">{{ $genre }}</label>
                                        </div>
                                    @endforeach
                                </div>
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
                    @if (request()->has('genre') || request()->has('year'))
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Search Results</h3>
                            <div class="table-responsive">
                                <table
                                    class="w-full table-fixed text-xs text-green-300 border-collapse border border-gray-700">
                                    <thead class="bg-blue-400 text-black">
                                        <tr>
                                            <th class="p-1 border border-gray-700 w-12">ID</th>
                                            <th class="p-1 border border-gray-700 w-40">Titolo</th>
                                            <th class="p-1 border border-gray-700 w-64">Sinossi</th>
                                            <th class="p-1 border border-gray-700 w-16">Img</th>
                                            <th class="p-1 border border-gray-700 w-12">Ep.</th>
                                            <th class="p-1 border border-gray-700 w-16">Status</th>
                                            <th class="p-1 border border-gray-700 w-16">In corso</th>
                                            <th class="p-1 border border-gray-700 w-16">Rating</th>
                                            <th class="p-1 border border-gray-700 w-16">Score</th>
                                            <th class="p-1 border border-gray-700 w-16">Anno</th>
                                            <th class="p-1 border border-gray-700 w-16">Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($animeData as $anime)
                                            <tr class="bg-gray-700 hover:bg-gray-800 transition">
                                                <td class="p-1 border border-gray-700 text-center">{{ $anime->mal_id }}</td>
                                                <td class="p-1 border border-gray-700 font-bold text-blue-300 text-center">
                                                    <x-add-anime-modal :anime="$anime" />
                                                </td>
                                                <td class="p-1 border border-gray-700">
                                                    {{ Str::limit($anime->synopsis, 30) }}
                                                </td>
                                                <td class="p-1 border border-gray-700 text-center">
                                                    <img src="{{ $anime->image_url }}" width="40" class="rounded-md">
                                                </td>
                                                <td class="p-1 border border-gray-700 text-center">
                                                    {{ $anime->episodes ?? 'Sconosciuto' }}</td>
                                                <td class="p-1 border border-gray-700 text-center">{{ $anime->status }}
                                                </td>
                                                <td class="p-1 border border-gray-700 text-center">
                                                    {{ $anime->airing ? 'Si' : 'No' }}</td>
                                                <td class="p-1 border border-gray-700 text-center">{{ $anime->rating }}
                                                </td>
                                                <td class="p-1 border border-gray-700 text-center">{{ $anime->score }}</td>
                                                <td class="p-1 border border-gray-700 text-center">{{ $anime->year }}</td>
                                                <td class="p-1 border border-gray-700 text-center">
                                                    <a href="{{ route('animes.show', $anime->id) }}"
                                                        class="px-2 py-1 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-500 transition">Dettagli</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $animeData->appends(request()->query())->links() }}
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
    </div>
@endsection
