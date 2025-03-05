<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AnimeController;
use App\Http\Livewire\AnimeList;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔹 Gruppo di rotte per gli Anime
Route::prefix('animes')->group(function () {
    // Route::get('/', [AnimeController::class, 'index'])->name('animes.index'); // Mostra tutti gli anime con paginazione
    Route::get('/', function () {
        return view('animes.index'); // Renderizza la vista Blade che contiene il componente Livewire
    });
    Route::get('/{id}', [AnimeController::class, 'show'])->name('animes.show'); // Mostra un singolo anime
    Route::get('/fetch/{mal_id}', [AnimeController::class, 'fetchAnime'])->name('animes.fetch'); // Recupera e salva da Jikan

    Route::middleware(['auth'])->group(function () { // Protegge modifiche/eliminazioni
        Route::delete('/{id}', [AnimeController::class, 'destroy'])->name('anime.destroy'); // Elimina anime
    });
});

Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});



require __DIR__ . '/auth.php';
