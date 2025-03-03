<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnimeController extends Controller
{
    // Funzione per recuperare tutti gli anime dal DB
    public function index()
    {
        try {
            $animes = Anime::all();  // Ottieni tutti gli anime
            if ($animes->isEmpty()) {
                return response()->json(['message' => 'No anime found'], 404);  // Se non ci sono anime nel DB
            }
            return response()->json($animes);  // Restituisci la lista degli anime
        } catch (\Exception $e) {
            Log::error('Errore nel recupero degli anime: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching anime list'], 500);
        }
    }

    // Funzione per recuperare dati da Jikan e salvarli nel DB
    public function fetchAnime($mal_id)
    {
        try {
            // Recupera i dati da Jikan
            $response = Http::withoutVerifying()->get("https://api.jikan.moe/v4/anime/{$mal_id}");

            // Verifica se la risposta è stata ricevuta con successo
            if ($response->successful()) {
                $data = $response->json()['data']; // Accede ai dati

                // Verifica che 'mal_id' sia presente nei dati
                if (!isset($data['mal_id'])) {
                    return response()->json(['error' => 'mal_id not found in data'], 400);
                }

                // Estrai i valori necessari
                $anime = Anime::updateOrCreate(
                    ['mal_id' => $data['mal_id']],
                    [
                        'title' => $data['title'], // Titolo principale
                        'synopsis' => $data['synopsis'] ?? null, // Sinossi
                        'image_url' => $data['images']['jpg']['image_url'] ?? null, // URL immagine
                        'episodes' => $data['episodes'] ?? null, // Numero episodi
                        'status' => $data['status'] ?? null, // Stato (e.g. "Finished Airing")
                        'airing' => $data['airing'] ?? null, // Se è ancora in onda
                        'rating' => $data['rating'] ?? null, // Rating
                        'score' => $data['score'] ?? null, // Punteggio
                        'synopsis' => $data['synopsis'] ?? null, // Sinossi
                        'year' => $data['year'] ?? null // Anno
                    ]
                );

                return response()->json($anime);
            }

            return response()->json(['error' => 'Anime not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
