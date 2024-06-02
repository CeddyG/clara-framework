<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <x-layout.container class="mt-4">
        <x-layout.row class="mb-3 justify-content-center"> 
            <x-layout.col size="8" size-md="6" size-lg="4">
                <x-card class="shadow p-3">
                    <x-form action="{{ route('login') }}">
                        <x-forms.text name="email" :label="__('Email')" required autofocus autocomplete="username" />
                        
                        <div class="mt-3">
                            <x-forms.password name="password" :label="__('Password')" required autocomplete="current-password" />
                        </div>
                        
                        <div class="mt-3">
                            <x-forms.checkbox name="remember" :label="__('Remember me')" />
                        </div>

                        <div class="d-flex align-items-center justify-content-end mt-4">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-button color="primary" class="ms-3" type="submit">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </x-form>
                </x-card>
            </x-layout.col>
        </x-layout.row>
    </x-layout.container>
</x-guest-layout>
