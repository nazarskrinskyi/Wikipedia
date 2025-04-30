<footer class="bg-gray-100 dark:bg-gray-800  shadow-sm  mb-0">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('home.index') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <x-application-logo />
                {{-- <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">ITWiki</span> --}}
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="{{ route('about') }}" class="hover:underline me-4 md:me-6">Про нас</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="hover:underline">Контакти</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a
                href="{{ route('home.index') }}" class="hover:underline">ITWiki™</a>. Всі права захищені.</span>
    </div>
</footer>
