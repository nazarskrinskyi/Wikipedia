<nav x-data="{ open: false }" id='navbar'
    class="w-full h-[var(--navbar-height)] bg-gray-100 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 z-50">
    <!-- Primary Navigation Menu -->
    <div
        class="flex justify-between items-center max-w-7xl h-full items-center mx-auto px-4
        sm:px-6 lg:px-8 py-2">
        <!-- Logo -->
        <div class='flex items-center'>
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home.index') }}">
                    <x-application-logo class="block h-9 w-auto fill-current" />
                </a>
            </div>

            @if (request()->routeIs('category.index'))
                <div class="text-logo font-semibold text-3xl ml-2 mr-1"> / </div>

                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="hidden text-logo sm:flex items-center px-1 py-2 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg ">
                    <a class="font-semibold text-3xl">
                        front-end
                    </a>
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <div id="dropdown"
                    class="z-10 hidden bg-gray-300 divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="#"
                                class="block text-xl px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200">

                                front-end
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block text-xl px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200">back-end
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        <div class='flex items-center self-center max-w-2xl flex-grow relative z-50 mx-1'>
            <x-search-input placeholder="Пошук по wiki" />

            {{-- Search Results --}}
            <div id='search-results'
                class="hidden
                    overflow-hidden absolute top-full left-0 w-full bg-white border rounded-md border-gray-200
                    dark:border-gray-700 shadow-lg z-100 dark:bg-gray-800">
            </div>
        </div>
        @if (Route::has('login'))
            <div class=" flex justify-end items-center">
                @auth
                    <a href="{{ url('/admin') }}"
                        class="rounded-md  px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Admin
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-md pl-8 px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="rounded-md pl-2 px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Settings Dropdown -->
        <div class="flex items-center">
            @if (Auth::user()?->name !== null)
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 ">
                                <div>{{ Auth::user()?->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif
            <x-theme-toggle />
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()?->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()?->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


<script>
    function debounce(callback, wait) {
        let timerId;
        return (...args) => {
            clearTimeout(timerId);
            timerId = setTimeout(() => {
                callback(...args);
            }, wait);
        };
    }

    function showSearchResults(data) {
        const searchResults = document.getElementById('search-results');
        if (data) {
            searchResults.style.display = 'block';
            searchResults.innerHTML = '';
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    const location = data[i];
                    const locationLink = document.createElement('a');
                    locationLink.href = '/location/' + location.id;
                    locationLink.textContent = location.name;
                    locationLink.classList.add('block', 'px-4', 'py-2', 'text-lg', 'text-gray-700', 'hover:bg-gray-100',
                        'dark:text-gray-200', 'dark:hover:bg-gray-600');
                    searchResults.appendChild(locationLink);
                }

            } else {
                const searchResult = document.createElement('span');
                searchResult.textContent = 'Нічого не знайдено';
                searchResult.classList.add('block', 'px-4', 'py-2', 'text-lg', 'text-gray-700', 'dark:text-gray-200');
                searchResults.appendChild(searchResult);
            }
        } else {
            searchResults.style.display = 'none';
        }

    }

    async function fetchSearchResults(query) {
        const result = await axios.post("/location/find-by-name", {
            query: query,
        });

        return result.data;
    }

    const handleFetchSearchResults = debounce(async (query) => {
        try {
            const data = await fetchSearchResults(query);

            if (data) {
                showSearchResults(data);
            }
        } catch (error) {
            console.error('error ' + error);
        }
    }, 500)

    function handleSearch(event) {
        event.preventDefault();

        const query = event.currentTarget.value;
        if (query !== '') {
            handleFetchSearchResults(query);
        } else {
            showSearchResults(null);
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');
        const main = document.querySelector('main');
        const navbarHeightValue = getComputedStyle(document.documentElement)
            .getPropertyValue('--navbar-height')
            .trim();

        const navbarHeight = parseInt(navbarHeightValue);


        window.addEventListener('scroll', function() {
            if (window.scrollY > navbarHeight) {
                navbar.classList.add('bg-white', 'dark:bg-black', 'fixed',
                    'animate-[slideDown_0.3s_ease-out]');
                navbar.classList.remove('dark:bg-gray-800');
                navbar.style.height = 'auto';
                main.style.paddingTop = navbarHeight + 'px';

            } else {
                navbar.classList.remove('bg-white', 'dark:bg-black', 'fixed',
                    'animate-[slideDown_0.3s_ease-out]');
                navbar.classList.add('dark:bg-gray-800');
                navbar.style.height = 'var(--navbar-height)';
                main.style.paddingTop = '0';
            }
        });
    });
</script>

<style>
    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }

        to {
            transform: translateY(0);
        }
    }
</style>
