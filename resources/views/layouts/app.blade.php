<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting()->title }}</title>

    <link href="{{ asset('css/plugin.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}" media="screen, print" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script src="{{ asset('js/plugin.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</head>

<body>
<div id="toppage" class="page">
    @include('inc.header')
    @yield('content')
</div>
@include('inc.footer')
<!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/buttons.colVis.min.js') }}"></script>

@stack('scripts')
</body>

</html>
