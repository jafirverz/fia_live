@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('page') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ url('admin/page/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="page-table" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Created on</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($pages->count())
                                @foreach($pages as $page)
                                    <tr>
                                        <td>
                                            {{$page->id}}
                                        </td>
                                        <td>
                                            {{$page->title}}
                                        </td>
                                        <td>
                                            {!! $page->slug   !!}
                                        </td>
                                        
                                        <td data-order="{{ $page->created_at }}">
                                            @if (!is_null($page->created_at))
                                               {{$page->created_at->format('d M, Y h:i A')}}
                                            @endif
                                        </td>
                                        <td data-order="{{ $page->updated_at }}">@if (!is_null($page->updated_at))
                                               {{$page->updated_at->format('d M, Y h:i A')}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/page/edit/' . $page->id) }}"
                                               title="Edit Page">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            @if(!in_array($page->page_type,[1,2]))
                                            <a href="{{ url('admin/page/destroy/' . $page->id) }}"
                                               title="Delete Page"  class=""
                                               onclick="return confirm('Are you sure you want to delete this Page?');">
                                                <i class="fa fa-trash btn btn-danger " aria-hidden="true"></i>
                                            </a>
                                            @endif
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
@endsection
