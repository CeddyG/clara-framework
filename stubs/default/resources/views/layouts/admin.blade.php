<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            @include('layouts.navigation-admin')
            
            <!-- Page Content -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                {{ $slot }}
            </div>
            
            <!-- /.content-wrapper -->
            <footer class="main-footer">
              <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
              </div>
              <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
              <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        
        {{ $scripts ?? '' }}
    </body>
</html>
