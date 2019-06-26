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
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($countries)
                                        @foreach($countries as $country)
                                            @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $country->tag_name }}</td>
                                            <td>{{ $category->tag_name }}</td>
                                            <td>
                                                <a href="{{ url('admin/country-information/list/' . $country->id . '/' . $category->id) }}" class="btn btn-info" title="List"><i class="fa fa-list" aria-hidden="true"></i> <span class="badge">{{ getCountryInformationCounter($country->id, $category->id) }}</span></a>
                                            </td>
                                        </tr>
                                            @endforeach
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
