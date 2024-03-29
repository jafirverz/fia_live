<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting()->title }}</title>
    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript,
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(/assets/dist/img/Preloader_2.gif) center no-repeat #fff;
        }
    </style>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <!-- Date Picker -->
    <link href="{{ asset('css/bootstrap-combined.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('assets/bower_components/datatables.net/Buttons-1.5.1/css/buttons.dataTables.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <!-- Scripts -->
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <script>
        //paste this code under head tag or in a seperate js file.
        // Wait for window load
        $(document).ready(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
        });
    </script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
	 var APP_URL = {!! json_encode(url('/')) !!} ;
    $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <script type="text/javascript">
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>


    </script>
    @stack('header-scripts')

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="se-pre-con"></div>
<div class="wrapper">
    @include('admin.inc.main-header')
    @include('admin.inc.main-sidebar')
    @yield('content')
    @include('admin.inc.control-sidebar')
</div>
</body>
<!-- Select2 -->
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<link rel="stylesheet" href="{{ url('css/bootstrap-datetimepicker.css') }}">
<script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
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
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" id="script"></script>
    <script src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}" id="script"></script>
    <script src="{{ asset('assets/dist/js/backend.js')}}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}" id="script"></script>

<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.datatable').DataTable();
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('.select2').select2({
            placeholder: '-- Select --',
        });

		 $('.pick_date_time').datetimepicker({
			 format: 'yyyy-mm-dd hh:ii',
            language: 'pt-BR' ,
           autoclose: true
    	});
    });



</script>
@stack('scripts')
</html>
