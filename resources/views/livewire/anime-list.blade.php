<div class="bg-white shadow-md rounded-lg p-6">
    <input type="text" wire:model.debounce.500ms="search" placeholder="Cerca un anime..."
        class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">

    @if ($animes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($animes as $anime)
                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}"
                        class="w-full h-64 object-cover rounded-md mb-4">
                    <h2 class="text-xl font-bold">{{ $anime->title }}</h2>
                    <p class="text-gray-600 text-sm">
                        {{ $anime->synopsis ? Str::limit($anime->synopsis, 100) : 'Nessuna descrizione' }}
                    </p>
                    <p class="mt-2 text-gray-800"><strong>Rating:</strong> {{ $anime->score ?? 'N/A' }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $animes->links() }} <!-- Paginazione -->
        </div>
    @else
        <p class="text-center text-gray-500">Nessun anime trovato.</p>
    @endif
</div>
