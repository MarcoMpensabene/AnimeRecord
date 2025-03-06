<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Anime;


class AnimeList extends Component
{
    use WithPagination;
    public $test = "test";
    public $search = ''; // Campo di ricerca
    protected $paginationTheme = 'tailwind'; // Usa il tema Tailwind per la paginazione
    public function updatingSearch()
    {
        $this->resetPage(); // Reset della paginazione quando cambia la ricerca
    }

    public function render()
    {
        // dd("Component is rendering");
        // // Query animes with search functionality if needed
        // $animeData = Anime::when($this->search, function ($query) {
        //     return $query->where('title', 'like', '%' . $this->search . '%');
        // })->paginate(9); // Use paginate instead of all()
        return view('livewire.anime-list', ['test']);
    }
}
