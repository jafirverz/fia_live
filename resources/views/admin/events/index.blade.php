@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('event') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ url('admin/events/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">

                                        <table id="datatable_event" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Event Title</th>
                                                <th>Event Date and time</th>
                                                <th>Event Image </th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($events->count())
                                                @foreach($events as $event)
                                                    <tr>
                                                        <td>
                                                            @if($event->event_title)
                                                                {{ strip_tags($event->event_title)   }}
                                                            @else
                                                                {{__('constant.NONE')}}
                                                            @endif
                                                        </td>



                                                        <td>
                                                            @if($event->event_date)
                                                                {{ date('j,F Y H:i A',strtotime($event->event_date)) }}
                                                            @else
                                                               {{__('constant.NONE')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                           <div class="attachment-block clearfix">
                                                                <img class="attachment-img"
                                                                     src="{!! asset($event->event_image) !!}"
                                                                     alt="Event Image">
                                                            </div>
                                                        </td>


                                                        <td data-order="{{ $event->created_at }}">
                                                            @if ($event->created_at == null)
                                                                {{$event->created_at}}
                                                            @endif
                                                            {{  $event->created_at->format('d M, Y h:i A')   }}

                                                        </td>
                                                        <td data-order="{{ $event->updated_at }}">@if ($event->updated_at == null)
                                                                {{$event->updated_at}}
                                                            @endif
                                                            {{  $event->updated_at->format('d M, Y h:i A')   }}

                                                        </td>
                                                        <td class="text-center">

                                           <a href="{{ url('admin/events/edit/' . $event->id) }}"
                                               title="Edit Event">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ url('admin/events/destroy/' . $event->id) }}"
                                               title="Destroy Event"
                                               onclick="return confirm('Are you sure you want to delete this event?');">
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
        $('#datatable_event').dataTable( {
            'order': [3, 'desc'],
        });
    });

</script>
@endsection
