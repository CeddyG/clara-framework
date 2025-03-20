<x-layout.row class="mb-2">
    <x-layout.col>
        <x-card class="card-primary card-outline">
            <x-form 
                :model="$item ?? null" 
                :method="isset($item) ? 'PUT' : 'POST'" 
                :action="isset($item) ? route('admin.roles.update', $item) : route('admin.roles.store')"
                >

                <x-card.header>
                    <h3 class="card-title">{{ isset($item) ? 'Edit' : 'Create' }}</h3>
                </x-card.header>

                <x-card.body>
                    <x-forms.text name="name" label="Name" />
                    <x-forms.text name="slug" label="Slug" />
                    <x-forms.select class="form-control select2" name="permissions[]" label="Permissions" :value="array_keys($item->permissions ?? [])" :options="$permissions" multiple />
                </x-card.body>

                <x-card.footer>
                    <x-button color="success" type="submit">Save</x-button>
                </x-card.footer>
            </x-form>
        </x-card>
    </x-layout.col>
</x-layout.row>
