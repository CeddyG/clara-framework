<section>
    <header>
        <h2>
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    
    <x-form action="{{ route('profile.update') }}" method="PATCH" :model="$user">
        <x-forms.text name="name" :label="__('Name')" required autofocus autocomplete="name" />

        <div class="mt-3">
            <x-forms.text name="email" :label="__('Email')" required autocomplete="username" />
            
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="mt-2">
                        {{ __('Your email address is unverified.') }}

                        <x-button type="submit" form="send-verification" class="text-white">
                            {{ __('Click here to re-send the verification email.') }}
                        </x-button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="d-flex align-items-center mt-3">
            <x-button color="primary" type="submit">{{ __('Save') }}</x-button>

            @if (session('status') === 'profile-updated')
                <x-alert color="success" class="ms-3 flex-grow-1 p-2 mb-0">
                    {{ __('Saved.') }}
                </x-alert>
            @endif
        </div>
    </x-form>
</section>
