<div class="d-flex justify-content-between bg-white border-bottom pe-2">
    <x-navbar class="p-0 bg-white">
        <x-slot name="brand" :url="route('dashboard')">
            <x-application-logo class="text-secondary" width="5rem" style="fill: currentColor;" />
        </x-slot>

        <x-nav.item style="height: 6rem" @class(['d-flex align-items-center', 'border-bottom border-primary' => Route::currentRouteName() === 'dashboard'])>
            <x-nav.link :href="route('dashboard')" :active="Route::currentRouteName() === 'dashboard'">
                {{ __('Dashboard') }}
            </x-nav.link>
        </x-nav.item>
    </x-navbar>
    
    <x-dropdown color="none" class="align-self-center">
        <x-slot name="heading">
            {{ Auth::user()->name }}
        </x-slot>
        
        <x-dropdown.item :href="route('profile.edit')">
            {{ __('Profile') }}
        </x-dropdown.item>

        <x-dropdown.item>
            <x-form :action="route('logout')">
                <x-forms.submit :value="__('Log Out')" color="none" class="p-0" />
            </x-form>
        </x-dropdown.item> 
    </x-dropdown>
</div>