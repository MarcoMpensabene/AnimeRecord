<?php

namespace App\Http\Controllers;

use App\Models\AnimeRecord;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimeRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $watchingAnime = Auth::user()->profile->animeRecords()->where('status', 'watching')->get();
        $completedAnime = Auth::user()->profile->animeRecords()->where('status', 'completed')->get();
        $planToWatchAnime = Auth::user()->profile->animeRecords()->where('status', 'plan_to_watch')->get();
        $droppedAnime = Auth::user()->profile->animeRecords()->where('status', 'dropped')->get();

        return view('animerecords.index', compact(
            'watchingAnime',
            'completedAnime',
            'planToWatchAnime',
            'droppedAnime'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anime_id' => 'required|exists:animes,id',
            'status' => 'required|in:watching,completed,plan_to_watch,dropped'
        ]);

        $profile = Auth::user()->profile;
        $profile->addAnime($request->anime_id, $request->status);

        return redirect()->back()->with('success', 'Anime added to your list!');
    }

    public function update(Request $request, AnimeRecord $animeRecord)
    {
        $this->authorize('update', $animeRecord);

        $request->validate([
            'status' => 'sometimes|in:watching,completed,plan_to_watch,dropped',
            'episodes_watched' => 'sometimes|integer|min:0',
            'rating' => 'sometimes|integer|min:1|max:10',
            'notes' => 'sometimes|string|max:1000'
        ]);

        if ($request->has('status')) {
            $animeRecord->profile->updateAnimeStatus($animeRecord->anime_id, $request->status);
        }

        if ($request->has('episodes_watched')) {
            $animeRecord->profile->updateAnimeProgress($animeRecord->anime_id, $request->episodes_watched);
        }

        if ($request->has('rating')) {
            $animeRecord->profile->rateAnime($animeRecord->anime_id, $request->rating);
        }

        if ($request->has('notes')) {
            $animeRecord->profile->addAnimeNote($animeRecord->anime_id, $request->notes);
        }

        return redirect()->back()->with('success', 'Anime record updated!');
    }

    public function destroy(AnimeRecord $animeRecord)
    {
        $this->authorize('delete', $animeRecord);

        $animeRecord->delete();
        return redirect()->back()->with('success', 'Anime removed from your list!');
    }
}