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
        {{ Breadcrumbs::render('country_edit', $country->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ url('admin/country/update', $country->id) }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('country_name') ? ' has-error' : '' }}">
                                <label for="">Country Name</label>
                                <input type="text" name="country_name" class="form-control"
                                    placeholder="Enter country name" value="{{ $country->country_name }}">
                                @if ($errors->has('country_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country_name') }}</strong>
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
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section>
</div>
@endsection
