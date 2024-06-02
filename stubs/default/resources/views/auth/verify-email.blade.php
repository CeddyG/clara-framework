<x-guest-layout>    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <x-layout.container class="mt-4">
        <x-layout.row class="mb-3 justify-content-center"> 
            <x-layout.col size="8" size-md="6" size-lg="4">
                <x-card class="shadow p-3">
                    <div class="mb-4 text-secondary">
                        <small>
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </small>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-secondary">
                            <small>
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </small>
                        </div>
                    @endif
                    
                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <x-form action="{{ route('verification.send') }}">
                            <x-button color="primary" class="ms-3" type="submit">
                                {{ __('Resend Verification Email') }}
                            </x-button>
                        </x-form>
                        
                        <x-form action="{{ route('logout') }}">
                            <x-button color="primary" class="ms-3" type="submit">
                                {{ __('Log Out') }}
                            </x-button>
                        </x-form>
                    </div>
                </x-card>
            </x-layout.col>
        </x-layout.row>
    </x-layout.container>
</x-guest-layout>