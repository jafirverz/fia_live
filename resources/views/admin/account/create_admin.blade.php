@extends('admin.layout.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>
        {{ Breadcrumbs::render('create_role') }}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        User Details
                    </div>

                    <form name="filter" method="post" action="{{ url('/admin/roles/store')}}">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group @if($errors->first('name')) has-error @endif">
                            <label>
                                Name
                            </label>
                            <input class="form-control" name="name" placeholder="Enter name" type="text"
                                value="{{  old('name') }}">
                            <span class="help-block">@if($errors->first('name')) {{ $errors->first('name') }}
                                @endif</span>
                        </div>
                        <div class="form-group @if($errors->first('email')) has-error @endif">
                            <label>
                                Email
                            </label>
                            <input class="form-control" name="email" placeholder="Enter email" type="email"
                                value="{{ old('email') }}">
                            <span class="help-block">@if($errors->first('email')) {{ $errors->first('email') }}
                                @endif</span>
                        </div>
                        <div class="form-group @if($errors->first('password')) has-error @endif">
                            <label>
                                Password
                            </label>
                            <input class="form-control" name="password" placeholder="Enter password" type="password"
                                value="">
                            <span class="help-block">@if($errors->first('password')) {{ $errors->first('password') }}
                                @endif</span>
                        </div>
                        <div class="form-group @if($errors->first('admin_role')) has-error @endif">
                            <label>
                                Role
                            </label>
                            <select name="admin_role" class="form-control">
                                <option value="">-- Select --</option>
                                @if($roles->count())
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="help-block">@if($errors->first('admin_role'))
                                {{ $errors->first('admin_role') }} @endif</span>
                        </div>
                        <div class="form-group @if($errors->first('status')) has-error @endif">
                            <label>
                                Status
                            </label>
                            <label class="radio-inline"><input type="radio" name="status" value="1" checked>Active</label>
                            <label class="radio-inline"><input type="radio" name="status" value="0">Inactive</label>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-primary" type="submit">
                            <i aria-hidden="true" class="fa fa-floppy-o">
                            </i>
                            Submit
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.row (main row) -->
<!-- /.content -->
<!-- /.content-wrapper -->
@endsection
