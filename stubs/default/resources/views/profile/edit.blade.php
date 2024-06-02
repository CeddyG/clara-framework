<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <x-card class="shadow">
            <div class="p-5">
                @include('profile.partials.update-profile-information-form')
            </div>
        </x-card>
        
        <x-card class="shadow mt-4">
            <div class="p-5">
                @include('profile.partials.update-password-form')
            </div>
        </x-card>
        
        <x-card class="shadow my-4">
            <div class="p-5">
                @include('profile.partials.delete-user-form')
            </div>
        </x-card>
    </div>
</x-app-layout>
