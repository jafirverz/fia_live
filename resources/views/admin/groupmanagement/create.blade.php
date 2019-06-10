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
        {{ Breadcrumbs::render('groupmanagement_create') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ url('admin/group-management/store') }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('group_name') ? ' has-error' : '' }}">
                                <label for="">Group Name</label>
                                <input type="text" name="group_name" class="form-control" placeholder="Enter group name"
                                    value="{{ old('group_name') }}">
                                @if ($errors->has('group_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('group_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Select Member</label>
                                <select class="form-control select2" name="group_members[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                    @foreach (member() as $member)
                                    <option value="{{ $member }}">{{ $member }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Member</label>
                                <select class="form-control select2" name="status" data-placeholder="Select a State" style="width: 100%;">
                                    @foreach (inactiveActive() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
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
