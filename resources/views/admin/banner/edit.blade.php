@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains banner content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('banner_edit', $banner->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                        <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                   <form name="filter" method="post" action="{{ url('/admin/banner/update/'.$banner->id)}}" enctype="multipart/form-data">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label class=" control-label">Page</label>

                            <div class="">

                                <select class="form-control select2"  name="page_name"  style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    @if($pages->count())
                                        @foreach($pages as $page)
                                            <option value="{{ $page->id }}"
                                                    @if($page->id == $banner->page_name) selected="selected" @endif>{{ $page->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                           
                            <div class="form-group">
                            <label for="banner_image" class=" control-label">Banner Photo</label>                            
                                <div class="row">
                                    <div class="@if(isset($banner->banner_image) && ($banner->banner_image != ''))col-sm-10 @endif">
                                      <input type="file" name="banner_image" class="form-control" placeholder="" />
                                        <p class="text-muted"><strong>Note:</strong> Image size should be 1400*635 for better display</p>
                                    </div>
                                    @if(isset($banner->banner_image) && ($banner->banner_image != ''))
                                        <div class=" col-sm-2">
                                            <div class="attachment-block clearfix">
                                                <img class="attachment-img" src="{!! asset($banner->banner_image) !!}"
                                                     alt="Banner Image">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="caption" class=" control-label">Caption</label>
                            
<input class="form-control" placeholder="" value="{{ $banner->caption }}" name="caption" type="text" id="caption">                            
                           
                        </div>
                            <div class="form-group">
                            <label for="order_by" class="control-label">Order By</label>                            
                                <div class="">
                                <input type="number" name="order_by" value="{{ $banner->order_by }}" class="form-control" />
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Save</button>
                        </div>
                        
                    </div>
                    </form>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
