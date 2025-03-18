<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'description',
        'favorite_characters'
    ];

    protected $casts = [
        'favorite_characters' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animeRecords()
    {
        return $this->hasMany(AnimeRecord::class);
    }

    public function addAnime($animeId, $status = 'plan_to_watch')
    {
        return $this->animeRecords()->create([
            'anime_id' => $animeId,
            'status' => $status
        ]);
    }

    public function updateAnimeStatus($animeId, $status)
    {
        return $this->animeRecords()->where('anime_id', $animeId)->update(['status' => $status]);
    }

    public function updateAnimeProgress($animeId, $episodesWatched)
    {
        return $this->animeRecords()->where('anime_id', $animeId)->update(['episodes_watched' => $episodesWatched]);
    }

    public function rateAnime($animeId, $rating)
    {
        return $this->animeRecords()->where('anime_id', $animeId)->update(['rating' => $rating]);
    }

    public function addAnimeNote($animeId, $note)
    {
        return $this->animeRecords()->where('anime_id', $animeId)->update(['notes' => $note]);
    }

    public function getAnimeList($status = null)
    {
        $query = $this->animeRecords()->with('anime');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }
}