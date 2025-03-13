@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile</h1>

                <form action="{{ route('profiles.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" id="username"
                            value="{{ old('username', $profile->username) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">About Me</label>
                        <textarea name="description" id="description" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">{{ old('description', $profile->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="favorite_characters" class="block text-sm font-medium text-gray-700">Favorite
                            Characters</label>
                        <div class="mt-1 space-y-2" id="characters-container">
                            @if ($profile->favorite_characters)
                                @foreach ($profile->favorite_characters as $character)
                                    <div class="flex items-center space-x-2">
                                        <input type="text" name="favorite_characters[]" value="{{ $character }}"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                        <button type="button" class="remove-character text-red-600 hover:text-red-800"
                                            onclick="this.parentElement.remove()">
                                            Remove
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addCharacterField()"
                            class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-700 bg-teal-100 hover:bg-teal-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Add Character
                        </button>
                        @error('favorite_characters')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('profiles.show') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function addCharacterField() {
                const container = document.getElementById('characters-container');
                const newField = document.createElement('div');
                newField.className = 'flex items-center space-x-2';
                newField.innerHTML = `
        <input type="text"
               name="favorite_characters[]"
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
        <button type="button"
                class="remove-character text-red-600 hover:text-red-800"
                onclick="this.parentElement.remove()">
            Remove
        </button>
    `;
                container.appendChild(newField);
            }
        </script>
    @endpush
@endsection
