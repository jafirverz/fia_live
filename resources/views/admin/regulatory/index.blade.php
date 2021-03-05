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
                        <table class="action-table pull-right">
                            <tr>
                                <td>
                                    <a href="{{ url('admin/regulatory/create') }}" class="btn btn-primary ">Create</a>
                                </td>
                                <td>
                                    <a href="{{ url('admin/regulatory/highlight/edit') }}" class="btn btn-primary pull-right">Highlight</a>
                                </td>
                                <td>
                                    <a href="{{ url('admin/regulatory?list=archive') }}" class="btn btn-primary pull-right">Archive</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-hover regulatory_datatable">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Agency Responsible</th>
                                            <!--<th>Date of Regulation in Force</th>-->
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
                                        <tr>
                                            <td>{{ $regulatory->title ?? '-' }}</td>
                                            <td>{{ $regulatory->agency_responsible ?? '-' }}</td>
                                            <?php /*?><td data-order="{{ $regulatory->date_of_regulation_in_force }}">@if($regulatory->date_of_regulation_in_force) {{ $regulatory->date_of_regulation_in_force->format('d M, Y') ?? '-' }} @else - @endif</td><?php */?>
                                            <td>
                                                @if($topics)
                                                @foreach($topics as $topic)
                                                    @if(in_array($topic->id, json_decode($regulatory->topic_id)))
                                                    {{ $topic->tag_name }},
                                                    @endif
                                                @endforeach
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>{{ getFilterCountry($regulatory->country_id) ?? '-' }}</td>
                                            <td data-order="{{ $regulatory->created_at }}">{{ $regulatory->created_at->format('d M, Y h:i A') ?? '-' }}</td>
                                            <td data-order="{{ $regulatory->updated_at }}">{{ $regulatory->updated_at->format('d M, Y h:i A') ?? '-' }}</td>
                                            <td>
                                                <table class="action-table">
                                                    <tr>

                                                        @if(!request()->input('list'))
                                                        <td>
                                                            <a href="{{ url('admin/regulatory/edit', $regulatory->id) }}" class="btn btn-info" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ url('admin/regulatory/destroy') }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                <input type="hidden" name="id" value="{{ $regulatory->id }}">
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('admin/regulatory/list', $regulatory->id) }}" class="btn btn-info" title="List"><i class="fa fa-list" aria-hidden="true"></i></a>
                                                        </td>
                                                        @else
                                                        <td>
                                                            <a href="{{ url('admin/regulatory/restore', $regulatory->id) }}" onclick="return confirm('Are you sure you want to restore?');" class="btn btn-info" title="Restore"><i class="fa fa-undo" aria-hidden="true"></i></a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ url('admin/regulatory/permanent-destroy') }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete permanently?');" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                <input type="hidden" name="id" value="{{ $regulatory->id }}">
                                                            </form>
                                                        </td>
                                                        @endif
                                                        
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
        $('.regulatory_datatable').DataTable({
            "order": [[ 5, "desc" ], [ 4, "desc" ]],
			"aoColumnDefs": [
			{ 
			  "bSortable": false, 
			  "aTargets": [ -1 ] // &lt;-- gets last column and turns off sorting
			 } 
		 ]
        });
    });



</script>
@endsection
