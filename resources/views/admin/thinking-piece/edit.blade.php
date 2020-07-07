@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('thinking_piece_edit', $thinking_piece->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                        <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
<form name="filter" method="post" action="{{ url('/admin/thinking_piece/update/'.$thinking_piece->id)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="box-body">
                <div class="form-group {{ $errors->has('thinking_piece_title') ? ' has-error' : '' }}"><div class="row">
                    <label class='col-sm-2 control-label'>Title:</label>
    <div class="col-sm-10"><input type="text" class="form-control" name="thinking_piece_title" id="thinking_piece_title"  value="{{$thinking_piece->thinking_piece_title,old( 'thinking_piece_title')}}">
                            @if ($errors->has('thinking_piece_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('thinking_piece_title') }}</strong>
                            </span>
                            @endif
                </div></div></div>
                <div class="form-group {{ $errors->has('thinking_piece_date') ? ' has-error' : '' }}">
                    <div class="row"><label class='col-sm-2 control-label'>Date:</label>
<div class="col-sm-10 date  pick_date_time"><input readonly="readonly" type="text" class="form-control" name="thinking_piece_date" id="thinking_piece_date" value="{{  $thinking_piece->thinking_piece_date  }}">
							 @if ($errors->has('thinking_piece_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('thinking_piece_date') }}</strong>
                            </span>
                            @endif
                <span class="add-on"><i class="icon-th"></i></span></div></div></div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <div class="row"><label class='col-sm-2 control-label' for="contents">Description :</label>
<div class="col-sm-10"><textarea class="tiny-editor form-control" rows="5" id="description"
                              name="description">{{ $thinking_piece->description }}</textarea>
                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif       
                              </div></div>
                </div>
                
               
               <div class="form-group{{ $errors->has('thinking_piece_image') ? ' has-error' : '' }}">
                           <div class="row">
                           <label for="thinking_piece_image" class="col-sm-2 control-label">Image</label>                            
                           <div class="col-sm-10"> <input type="file" name="thinking_piece_image" class="form-control" placeholder="" />
                             @if($thinking_piece->thinking_piece_image!="")                         
  <img src='{{ asset($thinking_piece->thinking_piece_image) }}' height="80" alt="" />
  @endif
                            
                            </div>
                            
                           </div>
                        </div>
                <div class="form-group {{ $errors->has('thinking_piece_image') ? ' has-error' : '' }}">
                  <div class="row">  <label class='col-sm-2 control-label'>Address:</label>
 <div class="col-sm-10"><textarea class="tiny-editor form-control" rows="5" id="thinking_piece_address"
                              name="thinking_piece_address">{{ $thinking_piece->thinking_piece_address }}</textarea>
                              
                         @if ($errors->has('thinking_piece_address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('thinking_piece_address') }}</strong>
                            </span>
                            @endif     
                              </div>
                </div>
               </div></div>
                                <!-- /.box-body -->
                                <div class="box-footer">


                                    <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i>Update
                                    </button>

                                </div>
                                <!-- /.box-footer -->
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
<script>
    $('#event_image').filemanager('image');
</script>
@endsection
