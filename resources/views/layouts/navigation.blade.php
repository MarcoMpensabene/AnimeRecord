<nav class="bg-indigo-200 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('animes.index') }}"
                        class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                        Anime List
                    </a>
                    <a href="{{ route('animes.search') }}"
                        class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                        Search
                    </a>
                    @auth
                        <a href="{{ route('animerecord.index') }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            My List
                        </a>
                    @endauth
                </div>
            </div>

            <div class="flex items-center">
                @auth
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ Auth::user()->name }}
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('profiles.show') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Logout
                                    </button>
                                </form>
                                <a href="{{ url('/dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</a>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Login</a>
                    <a href="{{ route('register') }}"
                        class="ml-4 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
