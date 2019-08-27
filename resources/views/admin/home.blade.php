@extends('admin.layout.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        {{ Breadcrumbs::render('dashboard') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dashboard</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <script src="{{ asset('js/Chart.min.js') }}" charset="utf-8"></script>
                <script src="{{ asset('js/utils.js') }}"></script>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Member Type Country</h2>

                        <div style="width:100%;">
                            {!! $chart1->render() !!}
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-12">
                        <h2>Membership Growth</h2>

                        <div style="width:100%;">
                            {!! $chart2->render() !!}
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
</div>
@endsection
