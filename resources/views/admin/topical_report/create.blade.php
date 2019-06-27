@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('topical_report_create') }}
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
		<form name="filter" method="post" action="{{ url('/admin/topical-report/store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
               <div class="box-body">
               <div class="form-group{{ $errors->has('topical_id') ? ' has-error' : '' }}">
                <label for="">Topic</label>
                <select name="topical_id[]" class="form-control select2" style="width: 100%;" multiple>
                    <option value="">-- Select --</option>
                    @if($topics)
                    @foreach ($topics as $topic)
                    <option value="{{ $topic->id }}" @if(old('topical_id')) @if(in_array($topic->id, old('topical_id'))) selected @endif @endif>{{ $topic->tag_name }}</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('topical_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('topical_id') }}</strong>
                </span>
                @endif
                </div>
               <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                                <label for="">Country</label>
                                <select name="country_id[]" class="form-control select2" style="width: 100%;" multiple>
                                    <option value="">-- Select --</option>
                                    @if($countries)
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if(old('country_id')) @if(in_array($country->id, old('country_id'))) selected @endif @endif>{{ $country->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('country_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                                @endif
                            </div>
                <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                
                    <label class='control-label'>Title:</label>
    <input type="text" class="form-control" name="title" id="title"  value="{{ old('title') }}">
               
               @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
                </div>
                
                <div class="form-group">
                
                                <label class='control-label' for="">Banner Image :</label>
                               <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="banner_image" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="banner_image">
                                    <img id="holder" style="margin-top:15px;max-height:100px;">
                                
                                
                                </div>
                               @if ($errors->has('banner_image'))
                <span class="help-block">
                    <strong>{{ $errors->first('banner_image') }}</strong>
                </span>
                @endif 
                 </div>
                <div class="form-group">
                
                                <label class='control-label' for="">PDF :</label>
                               <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="pdf" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="pdf">
                                    <img id="holder" style="margin-top:15px;max-height:100px;">
                                
                            </div> 
                @if ($errors->has('pdf'))
                <span class="help-block">
                    <strong>{{ $errors->first('pdf') }}</strong>
                </span>
                @endif  
                 </div>                    
                <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                
                    <label class='control-label' for="contents">Description :</label>
<textarea class="tiny-editor form-control" rows="5" id="description"
                              name="description">{{ old('description') }}</textarea>
                  @if ($errors->has('description'))
                <span class="help-block">
                               <strong>{{ $errors->first('description') }}</strong>
     </span>
                @endif            
                </div>
                
            </div>
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
    $('#banner_image').filemanager('image');
	$('#pdf').filemanager('image');
</script>
<!-- /.content-wrapper -->
@endsection

