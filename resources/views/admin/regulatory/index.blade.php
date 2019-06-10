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
        {{ Breadcrumbs::render('regulatory') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <a href="{{ url('admin/regulatory/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Agency Responsible</th>
                                            <th>Date of Regulation in Force</th>
                                            <th>Parent</th>
                                            <th>Topic</th>
                                            <th>Country</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($regulatories)
                                        @foreach($regulatories as $regulatory)
                                        @php
                                            $topics = getTopics($regulatory->topic_id);
                                        @endphp
                                        <tr>
                                            <td>{{ $regulatory->title ?? '-' }}</td>
                                            <td>{{ $regulatory->agency_reponsible ?? '-' }}</td>
                                            <td>{{ $regulatory->date_of_regulation_in_force->format('d M, Y') ?? '-' }}</td>
                                            <td>{{ getParentRegulatory($regulatory->parent_id) ?? '-' }}</td>
                                            <td>
                                                @if($topics)
                                                @foreach ($topics as $topic)
                                                    {{ $topic }}
                                                    @if (!$loop->last)
                                                    ,
                                                    @endif
                                                @endforeach
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>{{ getCountry($regulatory->country_id) ?? '-' }}</td>
                                            <td>{{ $regulatory->created_at->format('d M, Y') ?? '-' }}</td>
                                            <td>{{ $regulatory->updated_at->format('d M, Y') ?? '-' }}</td>
                                            <td>
                                                <a href="{{ url('admin/regulatory/edit', $regulatory->id) }}" class="btn btn-info" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <form action="{{ url('admin/regulatory/destroy') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    <input type="hidden" name="id" value="{{ $regulatory->id }}">
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
