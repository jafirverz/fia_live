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
        {{ Breadcrumbs::render('country_information') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <a href="{{ url('admin/country-information/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Country Name</th>
                                            <th>Country Flag</th>
                                            <th>Country Info. Title</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($country_information)
                                        @foreach($country_information as $country)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{ $country->information_title }}</td>
                                            <td>{{ $country->created_at->format('d M, Y H:i A') ?? '-' }}</td>
                                            <td>{{ $country->updated_at->format('d M, Y H:i A') ?? '-' }}</td>
                                            <td>
                                                <a href="{{ url('admin/country-information/edit', $country->id) }}" class="btn btn-info" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <form action="{{ url('admin/country-information/destroy') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    <input type="hidden" name="id" value="{{ $country->id }}">
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
