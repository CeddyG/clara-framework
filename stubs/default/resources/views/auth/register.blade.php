<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <x-layout.container class="mt-4">
        <x-layout.row class="mb-3 justify-content-center"> 
            <x-layout.col size="8" size-md="6" size-lg="4">
                <x-card class="shadow p-3">
                    <x-form action="{{ route('register') }}">
                        <x-forms.text name="name" :label="__('Name')" required autofocus autocomplete="name" />
                        
                        <div class="mt-3">
                            <x-forms.text name="email" :label="__('Email')" required autocomplete="username" />
                        </div>
                        
                        <div class="mt-3">
                            <x-forms.password name="password" :label="__('Password')" required autocomplete="new-password" />
                        </div>
                        
                        <div class="mt-3">
                            <x-forms.password name="password_confirmation" :label="__('Confirm Password')" required autocomplete="new-password" />
                        </div>

                        <div class="d-flex align-items-center justify-content-end mt-4">
                            <a href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <x-button color="primary" class="ms-3" type="submit">
                                {{ __('Register') }}
                            </x-button>
                        </div>
                    </x-form>
                </x-card>
            </x-layout.col>
        </x-layout.row>
    </x-layout.container>
</x-guest-layout>