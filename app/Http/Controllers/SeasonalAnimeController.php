<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SeasonalAnimeController extends Controller
{
    public function getCurrentSeason()
    {
        $now = Carbon::now();
        $month = $now->month;

        // Winter: January 1 - March 31
        if ($month >= 1 && $month <= 3) {
            return 'winter';
        }
        // Spring: April 1 - June 30
        elseif ($month >= 4 && $month <= 6) {
            return 'spring';
        }
        // Summer: July 1 - September 30
        elseif ($month >= 7 && $month <= 9) {
            return 'summer';
        }
        // Fall: October 1 - December 31
        else {
            return 'fall';
        }
    }

    public function getCurrentYear()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        // Se siamo tra gennaio e marzo, usiamo l'anno precedente per l'inverno
        if ($month <= 3) {
            return $year - 1;
        }

        return $year;
    }

    public function getSeasonalAnime()
    {
        try {
            $season = $this->getCurrentSeason();
            $year = $this->getCurrentYear();

            // Fetch from Jikan API
            $response = Http::withoutVerifying()
                ->get("https://api.jikan.moe/v4/seasons/{$year}/{$season}");

            if ($response->successful()) {
                $animeList = collect($response->json()['data'])
                    ->take(10) // Limit to 10 anime
                    ->map(function ($anime) {
                        return [
                            'mal_id' => $anime['mal_id'],
                            'title' => $anime['title'],
                            'image_url' => $anime['images']['jpg']['large_image_url'] ?? $anime['images']['jpg']['image_url'],
                            'score' => $anime['score'] ?? 'N/A',
                            'episodes' => $anime['episodes'] ?? '?',
                            'status' => $anime['status'] ?? 'Unknown',
                            'synopsis' => $anime['synopsis'] ?? '',
                            'genres' => collect($anime['genres'] ?? [])->pluck('name')->toArray(),
                            'rating' => $anime['rating'] ?? 'N/A',
                            'airing' => $anime['status'] === 'Currently Airing',
                            'broadcast' => $anime['broadcast'] ?? 'Unknown',
                            'source' => $anime['source'] ?? 'Unknown'
                        ];
                    });

                return response()->json($animeList);
            }

            return response()->json(['error' => 'Failed to fetch seasonal anime'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching seasonal anime: ' . $e->getMessage()], 500);
        }
    }
}