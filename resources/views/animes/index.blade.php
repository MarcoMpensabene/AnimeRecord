@extends('layouts.app')

@section('title', 'Lista Anime')

@section('content')
    <div class="max-w-7xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Lista degli Anime</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>MAL ID</th>
                        <th>Titolo</th>
                        <th>Sinossi</th>
                        <th>Immagine</th>
                        <th>Episodi</th>
                        <th>Status</th>
                        <th>In corso</th>
                        <th>Rating</th>
                        <th>Score</th>
                        <th>Anno</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($animeData as $anime)
                        <tr>
                            <td>{{ $anime->id }}</td>
                            <td>{{ $anime->mal_id }}</td>
                            <td>{{ $anime->title }}</td>
                            <td>{{ Str::limit($anime->synopsis, 50) }}</td>
                            <td><img src="{{ $anime->image_url }}" width="50"></td>
                            <td>{{ $anime->episodes }}</td>
                            <td>{{ $anime->status }}</td>
                            <td>{{ $anime->airing ? 'Si' : 'No' }}</td>
                            <td>{{ $anime->rating }}</td>
                            <td>{{ $anime->score }}</td>
                            <td>{{ $anime->year }}</td>
                            <td><a href="{{ route('animes.show', $anime->id) }}" class="btn btn-sm btn-primary">Dettagli</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-8 flex flex-col items-center w-full">
            <div
                class="inline-flex flex-wrap items-center justify-center gap-2 rounded-xl bg-white p-4 shadow-lg border border-gray-200">
                {{-- Previous Page Button --}}
                @if ($animeData->onFirstPage())
                    <span class="px-3 py-2 text-gray-400 cursor-not-allowed bg-gray-100 rounded-md">&laquo;</span>
                @else
                    <a href="{{ $animeData->previousPageUrl() }}"
                        class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">&laquo;</a>
                @endif

                {{-- First Page --}}
                <a href="{{ $animeData->url(1) }}"
                    class="px-3 py-2 {{ $animeData->currentPage() == 1 ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }} rounded-md">1</a>

                {{-- Pages --}}
                @php
                    $start = max(2, $animeData->currentPage() - 2);
                    $end = min($start + 4, $animeData->lastPage() - 1);
                    if ($end - $start < 4) {
                        $start = max(2, $end - 4);
                    }
                @endphp

                @if ($start > 2)
                    <span class="px-2 text-gray-400">...</span>
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $animeData->url($i) }}"
                        class="px-3 py-2 {{ $animeData->currentPage() == $i ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }} rounded-md">{{ $i }}</a>
                @endfor

                @if ($end < $animeData->lastPage() - 1)
                    <span class="px-2 text-gray-400">...</span>
                @endif

                {{-- Last Page --}}
                @if ($animeData->lastPage() > 1)
                    <a href="{{ $animeData->url($animeData->lastPage()) }}"
                        class="px-3 py-2 {{ $animeData->currentPage() == $animeData->lastPage() ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }} rounded-md">{{ $animeData->lastPage() }}</a>
                @endif

                {{-- Next Page Button --}}
                @if ($animeData->hasMorePages())
                    <a href="{{ $animeData->nextPageUrl() }}"
                        class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">&raquo;</a>
                @else
                    <span class="px-3 py-2 text-gray-400 cursor-not-allowed bg-gray-100 rounded-md">&raquo;</span>
                @endif
            </div>

            <div class="mt-4 flex items-center gap-2">
                <form action="" method="GET" class="flex items-center gap-2">
                    <label class="text-gray-600">Vai alla pagina:</label>
                    <input type="number" name="page" min="1" max="{{ $animeData->lastPage() }}"
                        value="{{ $animeData->currentPage() }}"
                        class="w-20 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-green rounded-md hover:bg-blue-700 transition">Vai</button>
                </form>
            </div>
        </div>
    </div>
@endsection
