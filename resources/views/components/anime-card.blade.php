@props(['anime'])

<div class="relative group">
    <div
        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700 xl:aspect-h-8 xl:aspect-w-7">
        <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}"
            class="h-full w-full object-cover object-center group-hover:opacity-75">
    </div>
    <div class="mt-4 flex justify-between">
        <div>
            <h3 class="text-sm text-gray-700 dark:text-gray-300">
                <button @click="$dispatch('open-modal')" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $anime->title }}
                </button>
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $anime->episodes }} Episodes</p>
        </div>
        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $anime->year }}</p>
    </div>
</div>

<x-add-anime-modal :anime="$anime" />
