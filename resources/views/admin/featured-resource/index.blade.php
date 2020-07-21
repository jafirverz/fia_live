@extends('admin.layout.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>
        {{ Breadcrumbs::render('featured_resource') }}
    </section>

    <!-- Main content -->
    <section class="content">
    @include('admin.inc.message')
        <form action="{{ url('admin/featured-resources/update') }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('featured_1_type') ? ' has-error' : '' }}">
                                <label for="">Featured 1</label>
                                <select name="featured_1_type" class="form-control select2" style="width: 100%;">
                                    <option value='null'>-- Select --</option>
                                    @if(getFeaturedResource())
                                    @foreach(getFeaturedResource() as $key=>$value)
                                    <option @if($featureResource->featured_1_type==$key) selected="selected" @endif  value='{{$key}}'>{{$value}}</option>
									@endforeach
                                    @endif
                                </select>
                                
                            </div>
                           <div class="form-group">
                            <select class="form-control select2" name="featured_1"  id="featured_1">
                            @if($featured_1)
                              @foreach($featured_1 as $key=>$value)
<option @if($featureResource->featured_1==$value->id) selected="selected" @endif value='{{$value->id}}'>@if($featureResource->featured_1_type==3) {{$value->thinking_piece_title}}  @else {{$value->title}} @endif</option>                              
                              @endforeach
                            @endif
                           </select>
							</div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('featured_2_type') ? ' has-error' : '' }}">
                                <label for="">Featured 2</label>
                                <select name="featured_2_type" class="form-control select2" style="width: 100%;">
                                   <option value='null'>-- Select --</option>
                                    @if(getFeaturedResource())
                                    @foreach(getFeaturedResource() as $key=>$value)
                                    <option @if($featureResource->featured_2_type==$key) selected="selected" @endif  value='{{$key}}'>{{$value}}</option>
									@endforeach
                                    @endif
                                   
                                </select>
                                
                            </div>
                           <div class="form-group">
                           <select class="form-control select2" name="featured_2"  id="featured_2">
                           @if($featured_2)
                              @foreach($featured_2 as $key=>$value)
<option @if($featureResource->featured_2==$value->id) selected="selected" @endif value='{{$value->id}}'>@if($featureResource->featured_2_type==3) {{$value->thinking_piece_title}}  @else {{$value->title}} @endif</option>                              
                              @endforeach
                            @endif
                           </select>
							</div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('featured_3_type') ? ' has-error' : '' }}">
                                <label for="">Featured 3</label>
                                <select name="featured_3_type" class="form-control select2" style="width: 100%;">
                                    <option value='null'>-- Select --</option>
                                    @if(getFeaturedResource())
                                    @foreach(getFeaturedResource() as $key=>$value)
                                    <option @if($featureResource->featured_3_type==$key) selected="selected" @endif  value='{{$key}}'>{{$value}}</option>
									@endforeach
                                    @endif
                                   
                                </select>
                                
                                
                            </div>
                           <div class="form-group">
                           <select class="form-control select2" name="featured_3"  id="featured_3">
                            @if($featured_3)
                              @foreach($featured_3 as $key=>$value)
<option @if($featureResource->featured_3==$value->id) selected="selected" @endif value='{{$value->id}}'>@if($featureResource->featured_3_type==3) {{$value->thinking_piece_title}}  @else {{$value->title}} @endif</option>                              
                              @endforeach
                            @endif
                           </select>
							</div>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section>
</div>
<script type="application/javascript">
$("body").on("change", "select[name='featured_1_type']", function() {
            var ref = $(this);
            var feature = ref.val();
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                    method: "POST",
                    url: '{{url("admin/featured-resources/detail")}}',
                    data:
                    {
                        feature: feature,
                        _token: CSRF_TOKEN,
                    },
                    cache: false,
                    async: false,
                    success: function (data) {
					  $('#featured_1').find('option').remove();
                      $('#featured_1').append(data);  
                    }
                });
        });
		
$("body").on("change", "select[name='featured_2_type']", function() {
            
            var ref = $(this);
            var feature = ref.val();
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                    method: "POST",
                    url: '{{url("admin/featured-resources/detail")}}',
                    data:
                    {
                        feature: feature,
                        _token: CSRF_TOKEN,
                    },
                    cache: false,
                    async: false,
                    success: function (data) {
					  $('#featured_2').find('option').remove();
                      $('#featured_2').html(data).selectpicker('refresh');  
                    }
                });
        
        });
		
$("body").on("change", "select[name='featured_3_type']", function() {
            
            var ref = $(this);
            var feature = ref.val();
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                    method: "POST",
                    url: '{{url("admin/featured-resources/detail")}}',
                    data:
                    {
                        feature: feature,
                        _token: CSRF_TOKEN,
                    },
                    cache: false,
                    async: false,
                    success: function (data) {
					  $('#featured_3').find('option').remove();
                      $('#featured_3').html(data).selectpicker('refresh');  
                    }
                });
        
        });				
</script>
@endsection
