@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('topical_report') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ url('admin/topical-report/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">

                                        <table id="datatable_report" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Topics</th>
                                                <th>Countries</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($TopicalReports->count())
                                                @foreach($TopicalReports as $TopicalReport)
                                                    <tr>
                                                        <td>
                                                            @if($TopicalReport->title)
                                                                {{ $TopicalReport->title   }}
                                                            @else
                                                                {{__('constant.NONE')}}
                                                            @endif
                                                        </td>


                                                        
                                                        <td>
                                                            @if($TopicalReport->topical_id)
                                                                {{ getTopicsName(json_decode($TopicalReport->topical_id))   }}
                                                            @else
                                                                {{__('constant.NONE')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                           
                                                                {{ getCountryByTopicalReportId($TopicalReport->id)  }}
                                                           
                                                        </td>
                                                        
                                                        
                                                        <td>
                                                            
                                                            {!!  date("Y-m-d H:i:s", strtotime($TopicalReport->created_at))   !!}

                                                        </td>
                                                        <td>
                                                            {!!  date("Y-m-d H:i:s", strtotime($TopicalReport->updated_at))   !!}

                                                        </td>
                                                        <td class="text-center">

                                           <a href="{{ url('admin/topical-report/edit/' . $TopicalReport->id) }}"
                                               title="Edit Topical Report">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ url('admin/topical-report/destroy/' . $TopicalReport->id) }}"
                                               title="Destroy Topical Report"
                                               onclick="return confirm('Are you sure you want to delete this Topical Report?');">
                                                <i class="fa fa-trash btn btn-danger" aria-hidden="true"></i>
                                            </a>

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
