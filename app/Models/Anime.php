<?php

// App\Models\Anime.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    // Aggiungi i nuovi campi alla proprietà $fillable
    protected $fillable = [
        'mal_id',
        'title',
        'synopsis',
        'image_url',
        'episodes',
        'status',
        'airing',
        'rating',
        'score',
        'year',
        'genres'
    ];

    protected $casts = [
        'airing' => 'boolean',
        'score' => 'float',
        'year' => 'integer',
        'genres' => 'array'
    ];
}