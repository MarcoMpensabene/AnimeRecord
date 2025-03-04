<?php


namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Anime;

class AnimeList extends Component
{
    use WithPagination;

    public $search = ''; // Campo di ricerca

    protected $paginationTheme = 'tailwind'; // Usa il tema Tailwind per la paginazione

    public function updatingSearch()
    {
        $this->resetPage(); // Reset della paginazione quando cambia la ricerca
    }

    public function render()
    {
        // Recupera gli anime dal database con paginazione
        $animes = Anime::where('title', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.anime-list', [
            'animes' => $animes, // Passa i dati alla view
        ]);
    }
}
