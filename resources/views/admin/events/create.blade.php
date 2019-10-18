@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('event_create') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                        <!-- general form elements -->
                    <!-- /.box-header -->
                    <div class="box box-primary">
                        <!-- form start -->
		<form name="filter" method="post" action="{{ url('/admin/events/store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
               <div class="box-body">
                <div class="form-group">
                <div class="row">
                    <label class='col-sm-2 control-label'>Event Title:</label>
    <div class="col-sm-10"><input type="text" class="form-control" name="event_title" id="event_title"  value="{{ old('event_title') }}">
                </div>
                </div></div>
                
                <div class="form-group"><div class="row">                
                    <label class='col-sm-2 control-label'>Event Date:</label>
<div class="col-sm-10 date  pick_date_time"><input readonly="readonly" type="text" class="form-control" name="event_date" id="event_date" value="{{ old('event_date') }}">
                <span class="add-on"><i class="icon-th"></i></span></div></div></div>
                <div class="form-group">
                <div class="row">
                    <label class='col-sm-2 control-label' for="contents">Description :</label>
<div class="col-sm-10"><textarea class="tiny-editor form-control" rows="5" id="description"
                              name="description">{{ old('description') }}</textarea></div>
                </div></div>
                
                <div class="form-group">
                <div class="row">
                                <label class='col-sm-2 control-label' for="">Event Image :</label>
                               <div class="col-sm-10"> <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="event_image" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="event_image">
                                </div>
                                   <p class="text-muted"><strong>Note:</strong>
                                       Image size should be 1400*470 for better display
                                   </p>
                                   <img id="holder" style="margin-top:15px;max-height:100px;">
                               </div>

                                </div>
                            </div>
                <div class="form-group">
                   <div class="row"> <label class='col-sm-2 control-label'>Event Address:</label>
 <div class="col-sm-10"><textarea class="tiny-editor form-control" rows="5" id="event_address"
                              name="event_address">{{ old('event_address') }}</textarea></div>
                </div>
               </div></div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Add
                    </button>
                </div>
                <!-- /.box-footer -->
		</form>

</div>
                    <!-- /.box-body -->
                </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script>
    $('#event_image').filemanager('image');
</script>
<!-- /.content-wrapper -->
@endsection

