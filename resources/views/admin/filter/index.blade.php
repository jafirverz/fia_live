@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('filter') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ url('admin/filter/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="datatable_filter" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Filter Name</th>
                                <th>Tag Name</th>
                                <th>Created</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($filters->count())
                                @foreach($filters as $filter)
                                    <tr>
                                        <td>
                                            @if($filter->id)
                                                {{ $filter->id   }}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($filter->filter_name)
                                                {{ get_filter_name_by_id($filter->filter_name)}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>

                                        <td>
                                            @if($filter->tag_name)
                                                {{ $filter->tag_name}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                       
                                        <td>
                                            @if ($filter->created_at == null)
                                                {{$filter->created_at}}
                                            @endif
                                            {{ $filter->created_at->format('d M, Y H:i A') }}

                                        </td>
                                        <td>@if ($filter->updated_at == null)
                                                {{$filter->updated_at}}
                                            @endif
                                            {{ $filter->updated_at->format('d M, Y H:i A') }}

                                        </td>
                                        <td>
                                            <a href="{{ url('admin/filter/edit/' . $filter->id) }}"
                                               title="Edit Filter">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ url('admin/filter/destroy/' . $filter->id) }}"
                                               title="Destroy Filter"
                                               onclick="return confirm('Are you sure you want to delete this filter?');">
                                                <i class="fa fa-trash btn btn-danger" aria-hidden="true"></i>
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
<script>
    $(document).ready(function() {
            $('#datatable_filter').dataTable( {
                'order': [],
            });
        });

</script>
@endsection
