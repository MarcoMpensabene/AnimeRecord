<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AnimeController;

class FetchAnimeData extends Command
{
    protected $signature = 'anime:fetch';
    protected $description = 'Fetch anime data from Jikan API';

    public function handle()
    {
        $this->info('Starting anime data fetch...');
        $controller = new AnimeController();
        $response = $controller->fetchAnime();
        $this->info('Anime data fetch completed!');
    }
}
