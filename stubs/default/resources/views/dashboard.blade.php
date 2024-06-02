<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    
    <div class="container mt-5">
        <x-card class="shadow">
            <div class="p-5">
                {{ __("You're logged in!") }}
            </div>
        </x-card>
    </div>
</x-app-layout>
