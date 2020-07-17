@extends('admin.layout.dashboard') 
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('podcast') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ url('admin/podcast/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">

                                        <table id="datatable_report" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Topics</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($podcasts->count())
                                                @foreach($podcasts as $podcast)
                                                    <tr>
                                                        <td>
                                                            @if($podcast->title)
                                                                {{ $podcast->title   }}
                                                            @else
                                                                {{__('constant.NONE')}}
                                                            @endif
                                                        </td>
														
                                                        <td>
                                                            @if($podcast->topical_id)
                                                                {!! strip_tags(getTopicsName(json_decode($podcast->topical_id)))   !!}
                                                            @else
                                                                {{__('constant.NONE')}}
                                                            @endif
                                                        </td>
                                                        
                                                        <td data-order="{{ $podcast->created_at }}">
                                                            
                                                            {{  $podcast->created_at->format('d M, Y h:i A')   }}

                                                        </td>
                                                        <td data-order="{{ $podcast->updated_at }}">
                                                           {{  $podcast->updated_at->format('d M, Y h:i A')   }}

                                                        </td>
                                                        <td class="text-center">
                                                            <table class="action-table">
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ url('admin/podcast/edit/' . $podcast->id) }}"
                                                                           title="Edit Podcast">
                                                                            <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ url('admin/podcast/destroy/' . $podcast->id) }}"
                                                                           title="Destroy Podcast"
                                                                           onclick="return confirm('Are you sure you want to delete this Topical Report?');">
                                                                            <i class="fa fa-trash btn btn-danger" aria-hidden="true"></i>
                                                                        </a>
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
        $('#datatable_report').dataTable( {
            'order': [3, 'desc'],
        });
    });

</script>
@endsection
