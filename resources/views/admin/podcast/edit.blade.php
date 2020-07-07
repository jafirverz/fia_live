@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('podcast_edit', $podcast->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                <!--@include('admin.inc.message')-->
                        <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
<form name="filter" method="post" action="{{ url('/admin/podcast/update/'.$podcast->id)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="box-body">
               <div class="form-group{{ $errors->has('topical_id') ? ' has-error' : '' }}">
                <label for="">Topic</label>
                <select name="topical_id[]" class="form-control select2" style="width: 100%;" multiple>
                    <option value="">-- Select --</option>
                    @if($topics)
                    @foreach ($topics as $topic)
                    <option value="{{ $topic->id }}"  @if($podcast->topical_id) @if(in_array($topic->id, json_decode($podcast->topical_id))) selected @endif @endif>{{ $topic->tag_name }}</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('topical_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('topical_id') }}</strong>
                </span>
                @endif
                </div>
               
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                
                    <label class='control-label'>Title:</label>
                    <input type="text" class="form-control" name="title" id="title"  value="{{ $podcast->title }}">
               
               @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
                </div>
               
                 <div class="form-group{{ $errors->has('audio_file') ? ' has-error' : '' }}">
                            <label for="audio_file" class=" control-label">Audio File</label>                            
                            <div class="">
                                <input type="file" name="audio_file" class="form-control" placeholder="" />
                               
                            </div>
                            @if ($errors->has('audio_file'))
                <span class="help-block">
                    <strong>{{ $errors->first('audio_file') }}</strong>
                </span>
                @endif
  @if($podcast->audio_file!="")                         
  <a href='{{ asset($podcast->audio_file) }}' target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Audio File</a>
  @endif
                        </div>                    
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                
                    <label class='control-label' for="contents">Description :</label>
<textarea class="tiny-editor form-control" rows="5" id="description"
                              name="description">{{ $podcast->description }}</textarea>
                  @if ($errors->has('description'))
                <span class="help-block">
                               <strong>{{ $errors->first('description') }}</strong>
     </span>
                @endif            
                </div>
                
            </div>
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
    $('#banner_image').filemanager('image');
</script>
@endsection
