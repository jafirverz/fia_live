@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains  content -->
<div class="content-wrapper">
    <!-- Content Header ( header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> 
        @if(isset($_GET['parent']) && $_GET['parent']!="")
        {{ Breadcrumbs::render('banner',$_GET['parent']) }}
        @else
        {{ Breadcrumbs::render('banner') }}
        @endif
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="menu-table" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>Banner Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                         <td>
                                            Home Page
                                        </td>
                                        <td>

                                            <a class="" title="Banner List"
                                               href="{{ url("admin/banner/type",["type"=>__('constant.BANNER_TYPE_HOME')]) }}">
                                                <i class="fa fa-list btn btn-default "> List</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Other Page
                                        </td>
                                        <td>

                                            <a class="" title="Banner List"
                                               href="{{ url("admin/banner/type",["type"=>__('constant.BANNER_TYPE_OTHER')]) }}">
                                                <i class="fa fa-list btn btn-default "> List</i>
                                            </a>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

