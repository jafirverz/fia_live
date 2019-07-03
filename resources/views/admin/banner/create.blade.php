@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains banner content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('banner_create') }}
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
                    
                    <form name="filter" method="post" action="{{ url('/admin/banner/store')}}" enctype="multipart/form-data">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="box-body">
                        <div class="form-group">
                            <label class=" control-label">Page</label>

                            <div class="">

                                <select class="form-control select2" name="page_name"
                                        style="width: 100%;">
									<option value="">-- Select --</option>
                                    @if($pages->count())
                                        @foreach($pages as $page)
                                            <option value="{{ $page->id }}" @if(old('page_name')==$page->id) selected="selected" @endif>{{ $page->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="banner_image" class=" control-label">Banner Photo</label>                            
                            <div class="">
                                <input type="file" name="banner_image" class="form-control" placeholder="" />
                                <p class="text-muted"><strong>Note:</strong> Image size should be 1400*635 for better display</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caption" class=" control-label">Caption</label>
                            
<input class="form-control" placeholder="" value="{{ old('caption') }}" name="caption" type="text" id="caption">                            
                           
                        </div>
                        <div class="form-group">
                            <label for="order_by" class=" control-label">Order By</label>                            
                            <div class="">
                                <input type="number" name="order_by" class="form-control" />
                            </div>
                        </div>
                        
                        
                        
                        
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>

                </div>
                <!-- /.box-body -->


                </form>
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

