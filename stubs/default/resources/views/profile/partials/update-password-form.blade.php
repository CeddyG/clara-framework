<section>
    <header>
        <h2>
            {{ __('Update Password') }}
        </h2>

        <p>
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <x-form action="{{ route('password.update') }}" method="PUT">
        <x-forms.password name="current_password" :label="__('Current Password')" autocomplete="current-password" />
        
        <div class="mt-3">
            <x-forms.password name="password" :label="__('New Password')" autocomplete="new-password" />
        </div>
        
        <div class="mt-3">
            <x-forms.password name="password_confirmation" :label="__('Confirm Password')" autocomplete="new-password" />
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
