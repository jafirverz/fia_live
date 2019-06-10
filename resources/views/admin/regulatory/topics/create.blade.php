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
        {{ Breadcrumbs::render('topic_create') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ url('admin/topic/store') }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('topic_name') ? ' has-error' : '' }}">
                                <label for="">Topic Name</label>
                                <input type="text" name="topic_name" class="form-control"
                                    placeholder="Enter topic name" value="{{ old('topic_name') }}">
                                @if ($errors->has('topic_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('topic_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section>
</div>
@endsection
