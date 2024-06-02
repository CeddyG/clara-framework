<x-guest-layout>    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <x-layout.container class="mt-4">
        <x-layout.row class="mb-3 justify-content-center"> 
            <x-layout.col size="8" size-md="6" size-lg="4">
                <x-card class="shadow p-3">
                    <div class="mb-4 text-secondary">
                        <small>
                            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                        </small>
                    </div>
                    
                    <x-form action="{{ route('password.confirm') }}">
                        <x-forms.password name="password" :label="__('Password')" required autofocus autocomplete="current-password" />

                        <div class="d-flex align-items-center justify-content-end mt-4">
                            <x-button color="primary" class="ms-3" type="submit">
                                {{ __('Confirm') }}
                            </x-button>
                        </div>
                    </x-form>
                </x-card>
            </x-layout.col>
        </x-layout.row>
    </x-layout.container>
</x-guest-layout>