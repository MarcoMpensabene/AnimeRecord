@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-indigo-600 mb-6">Dashboard</h1>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-white mb-2">Total Anime in List</h3>
                            <p class="text-3xl font-bold text-white">{{ \App\Models\AnimeRecord::count() }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-white mb-2">Recently Added</h3>
                            <p class="text-3xl font-bold text-white">{{ \App\Models\AnimeRecord::latest()->count() }}</p>
                        </div>
                    </div>

                    <!-- Recent Anime List -->
                    <div class="bg-white rounded-lg shadow border">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Anime Added</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Title
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Score
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Year
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach (\App\Models\AnimeRecord::latest()->take(5)->get('anime_id') as $animeRecord)
                                            @php
                                                $anime = \App\Models\Anime::find($animeRecord->anime_id);
                                            @endphp
                                            @if ($anime)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            @if ($anime->image_url)
                                                                <img class="h-10 w-10 rounded-full object-cover"
                                                                    src="{{ $anime->image_url }}" alt="{{ $anime->title }}">
                                                            @endif
                                                            <div class="ml-4">
                                                                <div
                                                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                                    {{ $anime->title }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-800">{{ $anime->score ?? 'N/A' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-800">{{ $anime->year ?? 'N/A' }}</div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
