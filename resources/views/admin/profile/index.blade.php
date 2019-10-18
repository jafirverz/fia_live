@extends('admin.layout.dashboard') @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        {{ $title }}
    </h1> {{ Breadcrumbs::render('admin_profile') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <form name="filter" method="post" action="{{ url('/admin/profile/update')}}" enctype="multipart/form-data">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                    <div class="box-body">
                        <div class="form-group">
                          <label for="">Profile</label>
                          <input name="profile" type="file" class="form-control" id="" placeholder="">
                          @if($admin->profile) <br/>
                          <img src="{{ asset($admin->profile) }}" class="img-responsive" width="100px"/>
                          @endif
                          <p class="help-block"></p>
                        </div>
                        <div class="form-group">
                          <label for="">New Password</label>
                          <input name="old_password" type="password" class="form-control" id="" placeholder="">
                          <p class="help-block"></p>
                        </div>
                        <div class="form-group">
                          <label for="">Confirm Password</label>
                          <input name="new_password" type="password" class="form-control" id="" placeholder="">
                          <p class="help-block"></p>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
