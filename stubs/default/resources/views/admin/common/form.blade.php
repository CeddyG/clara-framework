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
                        <li class="breadcrumb-item"><a href="{{ route('admin.'.$name.'.index') }}">{{ __($name.'.entity_name') }}</a></li>
                        <li class="breadcrumb-item active">{{ isset($item) ? __('common.edit') : __('common.create') }}</li>
                    </ol>
                </x-layout.col>
            </x-layout.row>
        </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
        <div class="container-fluid">
            @include('admin.'.$name.'.form')
        </div>
    </section>
</x-admin-layout>
