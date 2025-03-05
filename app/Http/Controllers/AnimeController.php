<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnimeController extends Controller
{
    // 🔹 Recupera tutti gli anime con paginazione
    public function index()
    {
        // try {
        //     $perPage = 10; // Numero di anime per pagina
        //     $animes = Anime::paginate($perPage);

        //     if ($request->wantsJson()) {
        //         // Se la richiesta è API, restituisci JSON
        //         return response()->json($animes);
        //     }

        //     // Se la richiesta è una normale visita al sito, restituisci la view
        //     return view('anime.index', compact('animes'));
        // } catch (\Exception $e) {
        //     Log::error('Errore nel recupero degli anime: ' . $e->getMessage());
        //     return response()->json(['error' => 'Error fetching anime list'], 500);
        // }
        // $animes = Anime::paginate(12);
        // return view('animes.index', compact('animes'));
    }


    // 🔹 Recupera un singolo anime dal DB
    public function show($id)
    {
        $anime = Anime::find($id);

        if (!$anime) {
            return response()->json(['error' => 'Anime not found'], 404);
        }

        return response()->json($anime);
    }

    // 🔹 Recupera i dati da Jikan e li salva nel DB
    public function fetchAnime($mal_id)
    {
        try {
            $response = Http::withoutVerifying()->get("https://api.jikan.moe/v4/anime/{$mal_id}");

            if ($response->successful()) {
                $data = $response->json()['data'];

                if (!isset($data['mal_id'])) {
                    return response()->json(['error' => 'mal_id not found in data'], 400);
                }

                // Salva o aggiorna l'anime
                $anime = Anime::updateOrCreate(
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

                return response()->json($anime);
            }

            return response()->json(['error' => 'Anime not found'], 404);
        } catch (\Exception $e) {
            Log::error('Errore nel fetch dell’anime: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching anime'], 500);
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
            Log::error('Errore nella creazione dell’anime: ' . $e->getMessage());
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
            Log::error('Errore nell’aggiornamento dell’anime: ' . $e->getMessage());
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
            Log::error('Errore nell’eliminazione dell’anime: ' . $e->getMessage());
            return response()->json(['error' => 'Error deleting anime'], 500);
        }
    }
}
