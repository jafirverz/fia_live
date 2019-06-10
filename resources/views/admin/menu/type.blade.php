@extends('admin.layout.app') @section('content')
        <!-- Content Wrapper. Contains  content -->
<div class="content-wrapper">
    <!-- Content Header ( header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('menu') }}
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
                        <table id="menu-table" class="table table-bordered table-striped">
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

                                            

                                            <a class="" title="Menu List"
                                               href="{{ route("get-sub-menu",["id"=>$menu->id]) }}">
                                                <i class="fa fa-list btn btn-default "></i>
                                            </a>
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
@push('scripts')
<script>
    $('#menu-table').DataTable(
            {
                "pageLength": 10,
                'ordering': true,
                'order': [[2, 'asc']],
                "aoColumnDefs": [{
                    "aTargets": [6],
                    "bSortable": false
                },
                    {width: 100, targets: 0},
                    {width: 150, targets: 1},
                    {width: 100, targets: 2},
                    {width: 150, targets: 3},
                    {width: 150, targets: 4},
                    {width: 150, targets: 5},
                    {width: 150, targets: 6}
                ]
            });
</script>
@endpush
