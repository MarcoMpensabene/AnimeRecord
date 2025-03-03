<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class AnimeController extends Controller
{
    // Funzione per recuperare dati da Jikan e salvarli nel DB
    public function fetchAnime($mal_id)
    {
        try {
            $response = Http::get("https://api.jikan.moe/v4/anime/{$mal_id}");

            if ($response->successful()) {
                $data = $response->json()['data'];

                // Log dei dati ricevuti
                Log::info('Dati ricevuti da Jikan', $data);

                // Aggiungi un log per verificare se updateOrCreate è chiamato
                Log::info('Salvando anime nel database', ['mal_id' => $data['mal_id']]);

                $anime = Anime::updateOrCreate(
                    ['mal_id' => $data['mal_id']],
                    [
                        'title' => $data['title'],
                        'synopsis' => $data['synopsis'] ?? null,
                        'image_url' => $data['images']['jpg']['image_url'] ?? null,
                        'episodes' => $data['episodes'] ?? null,
                        'status' => $data['status'] ?? null,
                    ]
                );

                // Log per il risultato di updateOrCreate
                Log::info('Anime salvato', ['anime' => $anime]);

                return response()->json($anime);
            }

            return response()->json(['error' => 'Anime not found'], 404);
        } catch (\Exception $e) {
            Log::error('Errore nel salvataggio anime: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mostra la lista degli anime nel DB
    public function index()
    {
        return response()->json(Anime::all());
    }

    // Elimina un anime dal DB
    public function destroy($id)
    {
        $anime = Anime::find($id);
        if ($anime) {
            $anime->delete();
            return response()->json(['message' => 'Anime deleted']);
        }
        return response()->json(['error' => 'Anime not found'], 404);
    }
}
