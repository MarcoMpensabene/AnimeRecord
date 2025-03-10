<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnimeController extends Controller
{
    // 🔹 Recupera tutti gli anime con paginazione
    public function index(Request $request)
    {
        try {
            $perPage = 10; // Numero di anime per pagina
            $animeData = Anime::paginate($perPage);

            if ($request->wantsJson()) {
                //         // Se la richiesta è API, restituisci JSON
                return response()->json($animeData);
            }

            //     // Se la richiesta è una normale visita al sito, restituisci la view
            return view('animes.index', compact('animeData'));
        } catch (\Exception $e) {
            Log::error("Errore nel recupero degli anime: " . $e->getMessage());
            return response()->json(['error' => 'Error fetching anime list'], 500);
        }
    }


    // 🔹 Recupera un singolo anime dal DB
    public function show($id)
    {
        try {
            $anime = Anime::findOrFail($id);

            if ($anime) {
                return view('animes.show', compact('anime'));
            }

            return redirect()->route('animes.index')
                ->with('error', 'Anime not found');
        } catch (\Exception $e) {
            Log::error("Error retrieving anime details: " . $e->getMessage());
            return redirect()->route('animes.index')
                ->with('error', 'Error retrieving anime details');
        }
    }

    // 🔹 Recupera i dati da Jikan e li salva nel DB
    public function fetchAnime()
    {
        try {
            // Get total pages from initial request
            $initialResponse = Http::withoutVerifying()->get("https://api.jikan.moe/v4/anime");

            if (!$initialResponse->successful()) {
                throw new \Exception("Failed to get initial anime data");
            }

            $pagination = $initialResponse->json()['pagination'];
            $totalPages = $pagination['last_visible_page'];

            // Process each page
            for ($page = 1; $page <= $totalPages; $page++) {
                try {
                    // Rate limiting - Jikan API requires 1 second between requests
                    sleep(1);

                    $response = Http::withoutVerifying()->get("https://api.jikan.moe/v4/anime?page={$page}");

                    if ($response->successful()) {
                        $animeList = $response->json()['data'];

                        foreach ($animeList as $data) {
                            if (!isset($data['mal_id'])) {
                                Log::warning("mal_id not found for anime on page {$page}");
                                continue;
                            }

                            // Salva o aggiorna l'anime
                            Anime::updateOrCreate(
                                ['mal_id' => $data['mal_id']],
                                [
                                    'title' => $data['title'],
                                    'synopsis' => $data['synopsis'] ?? null,
                                    'image_url' => $data['images']['jpg']['image_url'] ?? null,
                                    'episodes' => $data['episodes'] ?? null,
                                    'status' => $data['status'] ?? null,
                                    'airing' => $data['airing'] ?? null,
                                    'rating' => $data['rating'] ?? null,
                                    'score' => $data['score'] ?? null,
                                    'year' => $data['year'] ?? null
                                ]
                            );
                        }

                        Log::info("Processed page {$page} of {$totalPages}");
                    }
                } catch (\Exception $e) {
                    Log::error("Error processing page {$page}: " . $e->getMessage());
                    continue;
                }
            }

            return response()->json(['message' => 'Anime database updated successfully']);
        } catch (\Exception $e) {
            Log::error("Error in fetchAnime: " . $e->getMessage());
            return response()->json(['error' => 'Error fetching anime data'], 500);
        }
    }

    // 🔹 Crea un nuovo anime manualmente
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'mal_id' => 'required|integer|unique:animes,mal_id',
                'title' => 'required|string|max:255',
                'synopsis' => 'nullable|string',
                'image_url' => 'nullable|url',
                'episodes' => 'nullable|integer',
                'status' => 'nullable|string',
                'airing' => 'nullable|boolean',
                'rating' => 'nullable|string',
                'score' => 'nullable|numeric|min:0|max:10',
                'year' => 'nullable|integer'
            ]);

            $anime = Anime::create($validated);

            return response()->json($anime, 201);
        } catch (\Exception $e) {
            Log::error("Errore nella creazione dell'anime: " . $e->getMessage());
            return response()->json(['error' => 'Error creating anime'], 500);
        }
    }

    // 🔹 Aggiorna un anime esistente
    public function update(Request $request, $id)
    {
        try {
            $anime = Anime::find($id);

            if (!$anime) {
                return response()->json(['error' => 'Anime not found'], 404);
            }

            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'synopsis' => 'sometimes|nullable|string',
                'image_url' => 'sometimes|nullable|url',
                'episodes' => 'sometimes|nullable|integer',
                'status' => 'sometimes|nullable|string',
                'airing' => 'sometimes|nullable|boolean',
                'rating' => 'sometimes|nullable|string',
                'score' => 'sometimes|nullable|numeric|min:0|max:10',
                'year' => 'sometimes|nullable|integer'
            ]);

            $anime->update($validated);

            return response()->json($anime);
        } catch (\Exception $e) {
            Log::error("Errore nell'aggiornamento dell'anime: " . $e->getMessage());
            return response()->json(['error' => 'Error updating anime'], 500);
        }
    }

    // 🔹 Elimina un anime dal DB
    public function destroy($id)
    {
        try {
            $anime = Anime::find($id);

            if (!$anime) {
                return response()->json(['error' => 'Anime not found'], 404);
            }

            $anime->delete();
            return response()->json(['message' => 'Anime deleted successfully']);
        } catch (\Exception $e) {
            Log::error("Errore nell'eliminazione dell'anime: " . $e->getMessage());
            return response()->json(['error' => 'Error deleting anime'], 500);
        }
    }
}