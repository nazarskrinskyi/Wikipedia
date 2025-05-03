<x-app-layout>
    <div class="flex flex-col gap-6 py-12 container mx-auto">
        <x-slot name="footer">
            <x-footer />
        </x-slot>

        <!-- Heading -->
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Про нас</h1>

        <!-- Description -->
        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <p class="text-gray-800 dark:text-gray-200">
                <strong>ITWiki</strong> — це сучасна платформа, яка надає структуровану та доступну інформацію про світ
                інформаційних технологій.
                Мета проекту — стати корисним довідником для студентів, розробників, ІТ-ентузіастів та всіх, хто
                цікавиться цифровими технологіями.
            </p>
        </div>

        <!-- Features -->
        <div class="bg-gray-200 dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Функціонал сайту</h2>
            <ul class="list-disc list-inside text-gray-800 dark:text-gray-200 space-y-2">
                <li><strong>Статті:</strong> Детальні пояснення термінів, технологій, мов програмування, інструментів та
                    методологій.</li>
                <li><strong>Категорії:</strong> Зручне групування матеріалів за тематиками: Frontend, Backend, DevOps,
                    AI, тощо.</li>
                <li><strong>Пошук:</strong> Інтерактивний пошук, що допомагає швидко знаходити необхідну інформацію.
                </li>
                <li><strong>Редагування контенту:</strong> Можливість додавати та оновлювати матеріали (для
                    зареєстрованих користувачів).</li>
                <li><strong>Світла і темна тема:</strong> Підтримка тем оформлення для зручності користувача.</li>
            </ul>
        </div>

        <!-- Image -->
        <div class="flex justify-center">
            <img src="{{ asset('images/itwiki.svg') }}" alt="ITWiki Logo" class="rounded-lg w-1/2 h-32">
        </div>
    </div>
</x-app-layout>
