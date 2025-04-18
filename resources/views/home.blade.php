<x-app-layout>
    <div class="gap-6 py-12 container mx-auto">
        <x-slot name="footer">
            <x-footer />
        </x-slot>


        @if (session('success'))
            <x-pop-up message="{{ session('success') }}" />
        @endif




    </div>
</x-app-layout>
