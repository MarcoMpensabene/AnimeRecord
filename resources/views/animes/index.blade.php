@extends('layouts.app')

@section('title', 'Lista Anime')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center"
        style="background-image: url('https://itsaboutanime.wordpress.com/wp-content/uploads/2019/12/4k-anime-wallpapers-top-free-4k-anime-backgrounds.jpg');">
        <div class="w-full max-w-7xl p-4 bg-gray-900 bg-opacity-90 rounded-lg shadow-lg">
            <table class="w-full table-fixed text-xs text-green-300 border-collapse border border-gray-700">
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
                            <td class="p-1 border border-gray-700">{{ Str::limit($anime->synopsis, 30) }}</td>
                            <td class="p-1 border border-gray-700 text-center">
                                <img src="{{ $anime->image_url }}" width="40" class="rounded-md">
                            </td>
                            <td class="p-1 border border-gray-700 text-center">{{ $anime->episodes ?? 'Sconosciuto' }}</td>
                            <td class="p-1 border border-gray-700 text-center">{{ $anime->status }}</td>
                            <td class="p-1 border border-gray-700 text-center">{{ $anime->airing ? 'Si' : 'No' }}</td>
                            <td class="p-1 border border-gray-700 text-center">{{ $anime->rating }}</td>
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

        <div class="flex flex-col items-center mt-6">
            <nav class="flex items-center gap-1 bg-gray-700 p-2 rounded-lg">
                @if ($animeData->onFirstPage())
                    <span class="px-2 py-1 text-gray-400 bg-gray-600 rounded-md">&laquo;</span>
                @else
                    <a href="{{ $animeData->previousPageUrl() }}"
                        class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">&laquo;</a>
                @endif

                @php
                    $start = max(1, $animeData->currentPage() - 4);
                    $end = min($start + 8, $animeData->lastPage());
                    if ($end - $start < 8) {
                        $start = max(1, $end - 8);
                    }
                @endphp

                @if ($start > 1)
                    <a href="{{ $animeData->url(1) }}" class="px-2 py-1 rounded-md text-green-300 hover:bg-gray-600">1</a>
                    <span class="px-1 text-gray-400">...</span>
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $animeData->url($i) }}"
                        class="px-2 py-1 rounded-md {{ $animeData->currentPage() == $i ? 'bg-blue-400 text-black font-semibold' : 'text-green-300 hover:bg-gray-600' }}">{{ $i }}</a>
                @endfor

                @if ($end < $animeData->lastPage())
                    <span class="px-1 text-gray-400">...</span>
                    <a href="{{ $animeData->url($animeData->lastPage()) }}"
                        class="px-2 py-1 rounded-md {{ $animeData->currentPage() == $animeData->lastPage() ? 'bg-blue-400 text-black font-semibold' : 'text-green-300 hover:bg-gray-600' }}">{{ $animeData->lastPage() }}</a>
                @endif

                @if ($animeData->hasMorePages())
                    <a href="{{ $animeData->nextPageUrl() }}"
                        class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">&raquo;</a>
                @else
                    <span class="px-2 py-1 text-gray-400 bg-gray-600 rounded-md">&raquo;</span>
                @endif
            </nav>

            <div class="mt-4 mb-4 flex items-center gap-2">
                <form action="" method="GET" class="flex items-center gap-2">
                    <label class="text-black">Vai alla pagina:</label>
                    <input type="number" name="page" min="1" max="{{ $animeData->lastPage() }}"
                        value="{{ $animeData->currentPage() }}"
                        class="w-16 px-2 py-1 border border-gray-600 rounded-md bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">Vai</button>
                </form>
            </div>
        </div>
    </div>


@endsection
