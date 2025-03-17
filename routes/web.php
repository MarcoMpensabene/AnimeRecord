<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔹 Gruppo di rotte per gli Anime
Route::prefix('animes')->group(function () {
    Route::get('/', [AnimeController::class, 'index'])->name('animes.index'); // Mostra tutti gli anime con paginazione
    Route::get('/search', [AnimeController::class, 'search'])->name('animes.search'); // Pagina di ricerca
    Route::get('/fetch/{mal_id}', [AnimeController::class, 'fetchAnime'])->name('animes.fetch'); // Recupera e salva da Jikan
    Route::get('/{id}', [AnimeController::class, 'show'])->name('animes.show'); // Mostra un singolo anime

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

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profiles.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profiles.destroy');
});



require __DIR__ . '/auth.php';