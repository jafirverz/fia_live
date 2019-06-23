@extends('admin.layout.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
            <small>{{ $subtitle }}</small>
        </h1>
        {{ Breadcrumbs::render('topic') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <a href="{{ url('admin/topic/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Topic Name</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($topics)
                                        @foreach($topics as $topic)
                                        <tr>
                                            <td>{{ $topic->topic_name ?? '-' }}</td>
                                            <td>{{ $topic->created_at->format('d M, Y H:i A') ?? '-' }}</td>
                                            <td>{{ $topic->updated_at->format('d M, Y H:i A') ?? '-' }}</td>
                                            <td>
                                                <a href="{{ url('admin/topic/edit', $topic->id) }}" class="btn btn-info" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <form action="{{ url('admin/topic/destroy') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    <input type="hidden" name="id" value="{{ $topic->id }}">
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
@endsection
