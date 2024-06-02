<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/') }}" class="nav-link">Back to site</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.admin') }}" class="nav-link">Home</a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.admin') }}" class="brand-link">
        <img src="{{ asset('images/admin-logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <x-nav pills class="nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach (config('admin-navbar') as $key => $item)
                    @if (is_array($item))
                        <x-nav.item>
                            <x-nav.link href="#">
                                {!! $item[0] !!}
                                <i class="right fas fa-angle-left"></i>
                            </x-nav.link>

                            <x-nav class="nav-treeview">
                                @foreach ($item[1] as $subkey => $subitem)
                                    @can($subkey)
                                        <x-nav.item>
                                            <x-nav.link href="{{ route($subkey) }}">
                                                <i class="nav-icon far fa-circle"></i>
                                                {!! $subitem !!}
                                            </x-nav.link>
                                        </x-nav.item>
                                     @endcan
                                @endforeach
                            </x-nav>
                        </x-nav.item>
                    @else
                        @can($key)
                            <x-nav.item>
                                <x-nav.link href="{{ route($key) }}">
                                    {!! $item !!}
                                </x-nav.link>
                            </x-nav.item>
                        @endcan
                    @endif                    
                @endforeach
            </x-nav>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>