@extends('admin.layout.app') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('page') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ url('admin/page/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="page-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Created on</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($pages->count())
                                @foreach($pages as $page)
                                    <tr>
                                        <td>
                                            {{$page->id}}
                                        </td>
                                        <td>
                                            {{$page->title}}
                                        </td>
                                        <td>
                                            {!! $page->slug   !!}
                                        </td>
                                        
                                        <td>
                                            @if (!is_null($page->created_at))
                                                {!!  date("Y-m-d H:i:s", strtotime($page->created_at))   !!}
                                            @endif
                                        </td>
                                        <td>@if (!is_null($page->updated_at))
                                                {!!  date("Y-m-d H:i:s", strtotime($page->updated_at))   !!}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/page/edit/' . $page->id) }}"
                                               title="Edit Page">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            @if(!in_array($page->page_type,[1,2]))
                                            <a href="{{ url('admin/page/destroy/' . $page->id) }}"
                                               title="Delete Page"  class=""
                                               onclick="return confirm('Are you sure you want to delete this Page?');">
                                                <i class="fa fa-trash btn btn-danger " aria-hidden="true"></i>
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
@push('scripts')
<script>
    $('#page-table').DataTable(
            {
                "pageLength": 10,
                'ordering': true,
                'order': [[4, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [5],
                    "bSortable": false
                },
                    {width: 100, targets: 0},
                    {width: 150, targets: 1},
                    {width: 100, targets: 2},
                    {width: 150, targets: 3},
                    {width: 150, targets: 4},
                    {width: 150, targets: 5}
                ]
            });
</script>
@endpush