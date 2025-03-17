<?php

namespace App\Console\Commands;

use App\Http\Controllers\AnimeController;
use Illuminate\Console\Command;

class FetchAnimeCommand extends Command
{
    protected $signature = 'anime:fetch';
    protected $description = 'Fetch anime data from Jikan API and store in database';

    public function handle()
    {
        $this->info('Starting anime fetch...');

        $controller = new AnimeController();
        $response = $controller->fetchAnime();

        if ($response->getStatusCode() === 200) {
            $this->info('Anime fetch completed successfully!');
        } else {
            $this->error('Error fetching anime data');
        }
    }
}