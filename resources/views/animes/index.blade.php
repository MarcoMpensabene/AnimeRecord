@extends('layouts.app')

@section('title', 'Lista Anime')

@section('content')
    <div class="max-w-7xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Lista degli Anime</h1>

        @livewire('anime-list', ['animeData' => $animeData]) <!-- Includiamo il componente Livewire -->

    </div>
@endsection
