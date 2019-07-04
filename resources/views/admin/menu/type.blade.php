@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains  content -->
<div class="content-wrapper">
    <!-- Content Header ( header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> 
        @if(isset($_GET['parent']) && $_GET['parent']!="")
        {{ Breadcrumbs::render('menu',$_GET['parent']) }}
        @else
        {{ Breadcrumbs::render('menu') }}
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
                                <th>ID</th>
                                <th>Title</th>
                                <th>View order</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($menu_types->count())
                                @foreach($menu_types as $k=> $menu)
                                    <tr>
                                        <td>
                                            {{ $menu->id }}
                                        </td>
                                         <td>
                                            {{ $menu->menu_name }}
                                        </td>
                                        <td>
                                            {{ $menu->view_order }}
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route("type-edit",["id"=>$menu->id]) }}"
                                               title="Edit Menu">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>

                                            
                                           @if($menu->id==2)
                                            <a class="" title="Menu List"
                                               href="{{ route("menu",["parent"=>$menu->id]) }}">
                                                <i class="fa fa-list btn btn-default "></i>
                                            </a>
                                           @else
                                           <a class="" title="Menu List"
                                               href="{{ route("menu-list",["id"=>$menu->id]) }}">
                                                <i class="fa fa-list btn btn-default "></i>
                                            </a>
                                           @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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

