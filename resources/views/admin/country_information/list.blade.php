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
        {{ Breadcrumbs::render('country_information_list', $country_id, $information_filter_id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Country Info. Title</th>
                                        <th>Country</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Order</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($country_information)
                                        @foreach($country_information as $country)
                                            <tr>
                                                <td>{{ $country->information_title }}</td>
                                                <td>{{ getFilterCountry($country->country_id) }}</td>
                                                <td data-order="{{ $country->created_at }}">{{ $country->created_at->format('d M, Y h:i A') ?? '-' }}</td>
                                                <td data-order="{{ $country->updated_at }}">{{ $country->updated_at->format('d M, Y h:i A') ?? '-' }}</td>
                                                <td>{{ $country->ordering }}</td>
                                                <td>
                                                    <table class="action-table">
                                                        <tr>
                                                            <td>
                                                                <a href="{{ url('admin/country-information/edit', $country->id) }}"
                                                                   class="btn btn-info" title="Edit"><i class=" fa fa-pencil"
                                                                                                        aria-hidden="true"></i></a>
                                                            </td>
                                                            <td>
                                                                <form action="{{ url('admin/country-information/destroy') }}"
                                                                      method="post">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger"
                                                                            onclick="return confirm('Are you sure you want to delete?');"
                                                                            title="Delete"><i class="fa fa-trash"
                                                                                              aria-hidden="true"></i></button>
                                                                    <input type="hidden" name="id" value="{{ $country->id }}">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    </table>



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
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            "order": [[3, "asc"]]
        });
    });
</script>
@endsection
