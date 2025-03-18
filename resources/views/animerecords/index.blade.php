@extends('layouts.app')

@section('title', 'My Anime List')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">My Anime List</h1>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Watching Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Currently Watching</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($watchingAnime as $record)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                @if ($record->anime->image_url)
                                    <img src="{{ $record->anime->image_url }}" alt="{{ $record->anime->title }}"
                                        class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $record->anime->title }}</h3>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Episodes:
                                            {{ $record->episodes_watched }}/{{ $record->anime->episodes ?? '?' }}</span>
                                        @if ($record->rating)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                {{ $record->rating }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <form action="{{ route('animerecord.update', $record) }}" method="POST"
                                            class="flex space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="episodes_watched"
                                                value="{{ $record->episodes_watched }}" min="0"
                                                max="{{ $record->anime->episodes ?? 999 }}"
                                                class="w-20 px-2 py-1 border rounded">
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Update</button>
                                        </form>
                                        <form action="{{ route('animerecord.destroy', $record) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No anime currently watching.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Completed Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Completed</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($completedAnime as $record)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                @if ($record->anime->image_url)
                                    <img src="{{ $record->anime->image_url }}" alt="{{ $record->anime->title }}"
                                        class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $record->anime->title }}</h3>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Episodes:
                                            {{ $record->episodes_watched }}/{{ $record->anime->episodes ?? '?' }}</span>
                                        @if ($record->rating)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                {{ $record->rating }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <form action="{{ route('animerecord.update', $record) }}" method="POST"
                                            class="flex space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="rating" value="{{ $record->rating }}"
                                                min="1" max="10" class="w-20 px-2 py-1 border rounded"
                                                placeholder="Rating">
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Rate</button>
                                        </form>
                                        <form action="{{ route('animerecord.destroy', $record) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No completed anime.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Plan to Watch Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Plan to Watch</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($planToWatchAnime as $record)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                @if ($record->anime->image_url)
                                    <img src="{{ $record->anime->image_url }}" alt="{{ $record->anime->title }}"
                                        class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $record->anime->title }}</h3>
                                    <div class="flex justify-between items-center">
                                        <form action="{{ route('animerecord.update', $record) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="px-2 py-1 border rounded">
                                                <option value="watching">Start Watching</option>
                                                <option value="dropped">Drop</option>
                                            </select>
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Update</button>
                                        </form>
                                        <form action="{{ route('animerecord.destroy', $record) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No anime planned to watch.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Dropped Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Dropped</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($droppedAnime as $record)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                @if ($record->anime->image_url)
                                    <img src="{{ $record->anime->image_url }}" alt="{{ $record->anime->title }}"
                                        class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $record->anime->title }}</h3>
                                    <div class="flex justify-between items-center">
                                        <form action="{{ route('animerecord.update', $record) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="px-2 py-1 border rounded">
                                                <option value="watching">Start Watching</option>
                                                <option value="plan_to_watch">Plan to Watch</option>
                                            </select>
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Update</button>
                                        </form>
                                        <form action="{{ route('animerecord.destroy', $record) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No dropped anime.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
