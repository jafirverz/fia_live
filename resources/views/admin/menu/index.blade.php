@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains  content -->
<div class="content-wrapper">
    <!-- Content Header ( header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> 

        {{ Breadcrumbs::render('sub_menu',$parentMenu,$type) }}
        
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                   
                        <a href="{{ route("menu-create",["parent"=>$parent,"type"=>$type]) }}" class="btn btn-primary pull-right">Create</a>
                   
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="menu-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                               <th>S. No.</th>
                                <th>Title</th>
                                <th>Connected page</th>
                                
                                <th>Status</th>
                                <th>Created on</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($menus->count())
                           @php  $k=0; @endphp
                                @foreach($menus as $k=> $menu)
                                @php $k++; @endphp
                                    <tr>
                                        <td>
                                            {{ $k }}
                                        </td>
                                        <td>
                                            {{ $menu->title }}
                                        </td>
                                        <td>
                                            @if(!$menu->page)
                                                {{__('constant.NONE')}}
                                            @else
                                                {{ $menu->page->title }}
                                            @endif
                                        </td>
                                        
                                        <td>
                                            @if($menu->status==1)
                                                {{__('constant.ACTIVATE')}}
                                            @elseif($menu->status==0)
                                                {{__('constant.DEACTIVATE')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!is_null($menu->created_at))
                                                {!!  date("Y-m-d H:i:s", strtotime($menu->created_at))   !!}
                                            @endif
                                        </td>
                                        <td>@if (!is_null($menu->updated_at))
                                                {!!  date("Y-m-d H:i:s", strtotime($menu->updated_at))   !!}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route("menu-edit",["id"=>$menu->id,"parent"=>$parent,"type"=>$type]) }}"
                                               title="Edit Menu">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>

                                            <a href="{{ route("menu-destroy",["id"=>$menu->id,"parent"=>$parent]) }}"
                                               title="Delete Menu" class=""
                                               onclick="return confirm('Are you sure you want to delete this Menu?');">
                                                <i class="fa fa-trash btn btn-danger " aria-hidden="true"></i>
                                            </a>

                                            <a class="" title="Menu List"
                                               href="{{ route("get-sub-menu",["id"=>$menu->id,"type"=>$type]) }}">
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
