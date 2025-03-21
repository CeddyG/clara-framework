<x-admin-layout>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <x-layout.row class="mb-2">
                <x-layout.col size="6">
                    <h1>{{ __($name.'.entity_name') }}</h1>
                </x-layout.col>
                <x-layout.col size="6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="#">{{ __($name.'.entity_name') }}</a></li>
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
                        <x-card.header>
                            <h3 class="card-title">{{ __('common.list') }}</h3>
                        </x-card.header>
                        
                        <x-card.body>
                            <div class="dataTables_wrapper dt-bootstrap4">
                                {{ $dataTable->table() }}
                            </div>
                        </x-card.body>
                        
                        <x-card.footer>
                            <a href="{{ route('admin.'.$name.'.create') }}">
                                <x-button color="info" type="submit">{{ __('common.add') }}</x-button>
                            </a>
                        </x-card.footer>
                    </x-card>
                </x-layout.col>
            </x-layout.row>
        </div>
    </section>
    
    <x-slot:scripts>
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    </x-slot>
</x-admin-layout>
