@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center space-x-4 mb-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($profile->username) }}&background=0D9488&color=fff"
                        alt="{{ $profile->username }}" class="w-20 h-20 rounded-full">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $profile->username }}</h1>
                        <p class="text-gray-500">Member since {{ $profile->created_at->format('F Y') }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">About Me</h2>
                        <p class="mt-1 text-gray-600">{{ $profile->description ?? 'No description yet.' }}</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Favorite Characters</h2>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @if ($profile->favorite_characters && count($profile->favorite_characters) > 0)
                                @foreach ($profile->favorite_characters as $character)
                                    <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-sm">
                                        {{ $character }}
                                    </span>
                                @endforeach
                            @else
                                <p class="text-gray-500">No favorite characters added yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('profiles.edit') }}"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
