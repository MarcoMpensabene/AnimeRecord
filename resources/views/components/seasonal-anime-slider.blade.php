{{-- @props(['animeList'])

<div x-data="{ currentIndex: 0, anime: @json($animeList), total: @json(count($animeList)) }" class="relative w-full max-w-4xl mx-auto">
    <h3 class="text-2xl font-bold mb-4">Current Season Anime</h3>

    <!-- Container dello slider -->
    <div class="overflow-hidden relative">
        <div class="flex transition-transform duration-300 ease-out"
            :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">

            <!-- Singoli anime -->
            <template x-for="(anime, index) in anime" :key="anime.id">
                <div class="w-full flex-shrink-0">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col">
                        <div class="relative">
                            <img :src="anime.image_url" alt="" class="w-full h-[300px] object-cover">
                            <span x-show="anime.airing"
                                class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-sm">Airing</span>
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h4 class="font-bold text-lg mb-2 line-clamp-2" x-text="anime.title"></h4>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <template x-for="genre in anime.genres" :key="genre">
                                    <span
                                        class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-100 text-xs px-2 py-1 rounded"
                                        x-text="genre"></span>
                                </template>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-2 mt-auto">
                                <span class="flex items-center">
                                    ⭐ <span x-text="anime.score"></span>
                                </span>
                                <span x-text="anime.episodes + ' eps'"></span>
                                <span x-text="anime.status"></span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2" x-text="anime.synopsis">
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Bottoni di navigazione -->
    <div class="flex justify-between mt-4">
        <button @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : total - 1"
            class="p-2 bg-gray-300 dark:bg-gray-600 text-black dark:text-white rounded-full shadow-md">
            ◀️
        </button>
        <button @click="currentIndex = (currentIndex < total - 1) ? currentIndex + 1 : 0"
            class="p-2 bg-gray-300 dark:bg-gray-600 text-black dark:text-white rounded-full shadow-md">
            ▶️
        </button>
    </div>
</div> --}}
