@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('topical_report_edit', $topicalReport->id) }}
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
<form name="filter" method="post" action="{{ url('/admin/topical-report/update/'.$topicalReport->id)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="box-body">
               <div class="form-group{{ $errors->has('topical_id') ? ' has-error' : '' }}">
                <label for="">Topic</label>
                <select name="topical_id[]" class="form-control select2" style="width: 100%;" multiple>
                    <option value="">-- Select --</option>
                    @if($topics)
                    @foreach ($topics as $topic)
                    <option value="{{ $topic->id }}"  @if($topicalReport->topical_id) @if(in_array($topic->id, json_decode($topicalReport->topical_id))) selected @endif @endif>{{ $topic->tag_name }}</option>
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
                                     @php $topic_country = getCountryByTopicalReportId($topicalReport->id); $topic_country=explode(',',$topic_country);  @endphp
                                    <option value="{{ $country->id }}" @if(in_array($country->tag_name, $topic_country)) selected @endif>{{ $country->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('country_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                                @endif
                            </div>
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                
                    <label class='control-label'>Title:</label>
    <input type="text" class="form-control" name="title" id="title"  value="{{ $topicalReport->title }}">
               
               @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
                </div>
                
                <?php /*?><div class="form-group">
                
                                <label class='control-label' for="">Banner Image :</label>
                               <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="banner_image" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="banner_image">
                                
                                
                                </div>
        <img id="holder" @if($filter->banner_image!="") src="{{url($filter->banner_image)}}" @endif  style="margin-top:15px;max-height:100px;">
                               @if ($errors->has('banner_image'))
                <span class="help-block">
                    <strong>{{ $errors->first('banner_image') }}</strong>
                </span>
                @endif 
                 </div><?php */?>
                 <div class="form-group{{ $errors->has('pdf') ? ' has-error' : '' }}">
                            <label for="pdf" class=" control-label">PDF</label>                            
                            <div class="">
                                <input type="file" name="pdf" class="form-control" placeholder="" />
                               
                            </div>
                            @if ($errors->has('pdf'))
                <span class="help-block">
                    <strong>{{ $errors->first('pdf') }}</strong>
                </span>
                @endif
  @if($topicalReport->pdf!="")                         
  <a href='{{ asset($topicalReport->pdf) }}' target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Open PDF in New Tab</a>
  @endif
                        </div>                    
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                
                    <label class='control-label' for="contents">Description :</label>
<textarea class="tiny-editor form-control" rows="5" id="description"
                              name="description">{{ $topicalReport->description }}</textarea>
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
