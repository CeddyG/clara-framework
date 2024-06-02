<x-guest-layout>    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <x-layout.container class="mt-4">
        <x-layout.row class="mb-3 justify-content-center"> 
            <x-layout.col size="8" size-md="6" size-lg="4">
                <x-card class="shadow p-3">
                    <div class="mb-4 text-secondary">
                        <small>
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </small>
                    </div>
                    
                    <x-form action="{{ route('password.email') }}">
                        <x-forms.text name="email" :label="__('Email')" required autofocus />

                        <div class="d-flex align-items-center justify-content-end mt-4">
                            <x-button color="primary" class="ms-3" type="submit">
                                {{ __('Email Password Reset Link') }}
                            </x-button>
                        </div>
                    </x-form>
                </x-card>
            </x-layout.col>
        </x-layout.row>
    </x-layout.container>
</x-guest-layout>