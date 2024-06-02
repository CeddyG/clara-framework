<x-admin-layout>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <x-layout.row class="mb-2">
                <x-layout.col size="6">
                    <h1>Roles</h1>
                </x-layout.col>
                <x-layout.col size="6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">{{ isset($item) ? 'Edit' : 'Create' }}</li>
                    </ol>
                </x-layout.col>
            </x-layout.row>
        </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
        <div class="container-fluid">
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
        </div>
    </section>
    
    <x-slot:scripts>
        <script type="module">
            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();
            });
        </script>
    </x-slot>
</x-admin-layout>
