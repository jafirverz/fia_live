<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Multi Auth Guard') }}</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" type="text/css" media="screen"
          href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/Ionicons/css/ionicons.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
          href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
          href="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <!-- assetsLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <!-- jQuery 3 -->
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <style>
            div.form-group>.bootstrap-select + input {margin-top: 15px;}
        </style>
    <script>
        window.Laravel =
                <?php echo json_encode([
                           'csrfToken' => csrf_token(),
                       ]); ?>

                       var APP_URL = {!! json_encode(url('/')) !!}
    </script>

</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
    @include('admin.inc.header')
    @include('admin.inc.aside')
    @yield('content')
    @include('admin.inc.footer')
</div>

</body>

<!-- Select2 -->
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/plugins/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->

<script src="{{ asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
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
<script src="{{ asset('assets/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs/buttons.colVis.min.js') }}"></script>
<!-- assetsLTE backend js -->
<script src="{{ asset('assets/dist/js/jquery.numeric.js') }}"></script>
<!-- assetsLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/dist/js/pages/dashboard.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" id="script"></script>
<script src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}" id="script"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" id="script"></script>
<!-- assetsLTE App -->
<script src="{{ asset('assets/dist/js/backend.js')}}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('.pick_date_time').datetimepicker({
        autoclose: true
    });
    $(document).ready(function () {
        $('#datatable').DataTable();
        $('.daterange').daterangepicker();
    })
</script>
<script type="text/javascript">
    $("#paid_event").on("click", function () {
        if (this.checked) {
            $('#dis_price').css('display', 'block');
        }
        else {
            $('#dis_price').css('display', 'none');
        }
    });

    $('.unqique_dicsount').on('keyup', function () {
        var sequentialcode = $("#sequentialcode").val();
        var discount_type_acronym = $("#discount_type_acronym").val();
        var disc_range = $("#disc_range").val();
        var discount_code = sequentialcode + discount_type_acronym + disc_range ;
        $("#discount_code").val(discount_code);
    });


$(document).ready(function() {
    $('#datatable_misc').DataTable( {
        "order": [[ 3, "asc" ]]
    } );
} );
$(document).ready(function() {
    $('#datatable_news').DataTable( {
        "order": [[ 2, "asc" ]]
    } );
} );
</script>
@stack('scripts')
</html>
