<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimeRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'anime_id',
        'status',
        'episodes_watched',
        'rating',
        'notes'
    ];

    protected $casts = [
        'rating' => 'integer',
        'episodes_watched' => 'integer'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}