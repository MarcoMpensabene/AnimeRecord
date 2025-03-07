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
    </div>
@endsection
