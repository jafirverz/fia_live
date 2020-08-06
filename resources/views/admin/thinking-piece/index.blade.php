@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('thinking_piece') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                  <table class="action-table pull-right">
                    <tr>
                        <td>  <a href="{{ url('admin/thinking_piece/create') }}" class="btn btn-primary pull-right">Create</a></td>
                        <td><a href="{{ url('admin/featured-resources') }}" class="btn btn-primary pull-right">Featured</a></td>
                    </tr>
                    </table>
                        
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">

                                        <table id="datatable_event" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Date and time</th>
                                                <th>Image </th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($thinkingPiece->count())
                                                @foreach($thinkingPiece as $thinking)
                                                    <tr>
                                                        <td>
                                                            @if($thinking->thinking_piece_title)
                                                                {{ strip_tags($thinking->thinking_piece_title)   }}
                                                            @else
                                                                {{__('constant.NONE')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($thinking->thinking_piece_author)
                                                                {{ strip_tags($thinking->thinking_piece_author)   }}
                                                            @else
                                                                {{__('constant.NONE')}}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if($thinking->thinking_piece_date)
                                                                {{ date('j F, Y H:i A',strtotime($thinking->thinking_piece_date)) }}
                                                            @else
                                                               {{__('constant.NONE')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                           <div class="attachment-block clearfix">
                                                                <img class="attachment-img"
                                                                     src="{!! asset($thinking->thinking_piece_image) !!}"
                                                                     alt="">
                                                            </div>
                                                        </td>


                                                        <td data-order="{{ $thinking->created_at }}">
                                                            @if ($thinking->created_at == null)
                                                                {{$thinking->created_at}}
                                                            @endif
                                                            {{  $thinking->created_at->format('d M, Y h:i A')   }}

                                                        </td>
                                                        <td data-order="{{ $thinking->updated_at }}">@if ($thinking->updated_at == null)
                                                                {{$thinking->updated_at}}
                                                            @endif
                                                            {{  $thinking->updated_at->format('d M, Y h:i A')   }}

                                                        </td>
                                                        <td class="text-center">

                                           <a href="{{ url('admin/thinking_piece/edit/' . $thinking->id) }}"
                                               title="Edit Thinking Piece">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ url('admin/thinking_piece/destroy/' . $thinking->id) }}"
                                               title="Destroy Thinking Piece"
                                               onclick="return confirm('Are you sure you want to delete this Thinking Piece?');">
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
            'order': [4, 'desc'],
        });
    });

</script>
@endsection
