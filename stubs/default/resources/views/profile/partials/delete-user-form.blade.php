<section class="space-y-6">
    <header>
        <h2>
            {{ __('Delete Account') }}
        </h2>

        <p>
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>
    
    <x-modal>
        <x-slot name="button" color="danger">
            {{ __('Delete Account') }}
        </x-slot>
        
        <x-form action="{{ route('profile.destroy') }}" method="DELETE">
            <x-modal.header>
                <h3 class="modal-title">{{ __('Delete Account') }}</h3>
                <x-btn-close data-bs-dismiss="modal" />
            </x-modal.header>
            <x-modal.body>
                <h2>
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p>
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
                
                <x-forms.password name="password" :label="__('Password')" />
            </x-modal.body>
            <x-modal.footer>
                <x-button color="secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</x-button>
                <x-button color="primary" type="submit">{{ __('Delete Account') }}</x-button>
            </x-modal.footer>
        </x-form>
    </x-modal>
</section>
