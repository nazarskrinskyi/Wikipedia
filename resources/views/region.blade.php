<x-app-layout>

    <div class="flex flex-col gap-6 py-12 container mx-auto">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $region->name }}</h2>
        </x-slot>

        <x-slot name="footer">
            <x-footer />
        </x-slot>
        <!-- Description about region -->

        <!-- Filtering buttons -->
        <div><x-region.dropdown-filtering-button :href="route('location.index', $region->code)" :currentOption="$filter" /></div>

        <!-- List of locations -->
        <div class="grid grid-cols-4 gap-6">
            @if (count($locations) == 0)
                <div
                    class='w-full col-span-4 flex items-center justify-center h-48 text-center text-xl font-semibold text-gray-800 dark:text-gray-200 '>
                    Локацій в області відсутні
                </div>
            @else
                @foreach ($locations as $location)
                    <x-location-card :image="asset('uploads/' . $location->image_path)" :id="$location->id" :title="$location->name" :rating="intval($location->avg_rating) == $location->avg_rating
                        ? intval($location->avg_rating)
                        : number_format($location->avg_rating, 1)" />
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
