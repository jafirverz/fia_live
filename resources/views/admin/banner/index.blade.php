@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains banner content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('banner-type',$type) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ route('banner.create',['type'=>$type]) }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="datatable_banner" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>Page</th>
                                <th>Image</th>
                                <th>View Order</th>
                                <th>Created on</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($banners->count())
                                @foreach($banners as $banner)
                                    <tr>
                                        
                                        <td>
                                            @if(!$banner->page_name)
                                                {{__('constant.NONE')}}
                                            @else
                                                {{ get_page_name($banner->page_name) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($banner->banner_image)
                                                <div class="attachment-block clearfix">
                                                    <img class="attachment-img"
                                                         src="{!! asset($banner->banner_image) !!}"
                                                         alt="Banner Image">
                                                </div>
                                            @else
                                                {{__('constant.NONE')}}
                                            @endif

                                        </td>
                                        <td>
                                            {!! $banner->order_by   !!}
                                        </td>
                                        <td data-order="{{ $banner->created_at }}">
                                            @if (!is_null($banner->created_at))
                                                {{$banner->created_at->format('d M, Y h:i A')}}
                                            @endif
                                        </td>
                                        <td data-order="{{ $banner->updated_at }}">@if (!is_null($banner->updated_at))
                                                {{$banner->updated_at->format('d M, Y h:i A')}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('banner.edit',["id"=>$banner->id,"type"=>$type]) }}"
                                               title="Edit Banner">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            @if(!in_array($banner->banner_type,[1,2]))
                                                <a href="{{ route('banner.destroy',["id"=>$banner->id,"type"=>$type]) }}"
                                                   title="Delete Banner" class=""
                                                   onclick="return confirm('Are you sure you want to delete this Banner?');">
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
