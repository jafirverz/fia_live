@extends('layouts.app')

@section('content')
      <div class="main-wrap">   
				@include('inc.banner')
				<div class="filter-wrap fw-type">
					<div class="container">						
						<div class="tb-col break-480">
				<form name="filter" method="get" action="{{ url('/topical-reports/search')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                	<div class="col">
								<label>Filter by</label>
								<div class="w-1">
									<select name="topic" onchange="this.form.submit()" class="selectpicker">
										<option value="">Topic</option>
                                        @foreach(getAllTopics() as $name)
                                        <option @if($data['topic']==$name->id) selected="selected" @endif value="{{$name->id}}">{{$name->tag_name}}</option>
                                        @endforeach
									</select>
								</div>
							</div>
                </form>	
							<div class="col">
								<a class="lk-back" href="#">Clear all</a>
							</div>
					</div>
					</div>
				</div>
				<div class="container space-1">
					<h1 class="title-1 text-center">{!!$page->title!!}</h1>
					<div class="intro-1">
						{!!$page->contents!!}
					</div>
					<div class="mbox-wrap" data-num="{{ setting()->pagination_limit }}">
                    @php $i=0; @endphp
                    @foreach($reports as $report)	
                    @php $i++; @endphp					
						<div class="box-3 mbox @if($i==1) open @endif">
							<a class="head-box" data-height="120" href="#report-1">@php $topics=json_decode($report->topical_id); @endphp {{getTopics($topics)}} : {{$report->title}}</a>
							<div class="content-box" id="report-1">
								<div class="document">
									{!!$report->description!!}
								</div>
							</div>
							<div class="foot-box">
								<div class="tb-col break-720">
									<div class="col">
										<h4>Countries which have regulations or draft regulations:</h4>
										<div class="flag-wrap">{!!getCountryImages($report->id)!!}</div>
									</div>
                                    
									<div class="col">
                                     @if(Auth::check())
										@if($report->pdf!="")<a class="btn-4" href="{{url(asset($report->pdf))}}" target="_blank"><i class="far fa-file-pdf"></i> Open PDF in New Tab</a>@endif
                                     @else
                                     <a href="#find-pp" class="btn-4" data-toggle="modal"><i class="far fa-file-pdf"></i> Open PDF in New Tab</a>
                                     @endif
									</div>
                                    
								</div>
							</div>
						</div>	
                    @endforeach
                    @if(count($reports)>setting()->pagination_limit)
						<div class="more-wrap"><button class="btn-4 mbox-load"> Load more <i class="fas fa-angle-double-down"></i></button></div>
                     @endif
					</div>
					
				</div>
                
            </div>
            
@if ($errors->any())           
<script type="text/javascript">
    $(window).on('load',function(){
        $('#find-pp').modal('show');
    });
</script> 
@endif
	  <div id="find-pp" class="modal fade">
		  <div class="modal-dialog">
			  <div class="modal-content">
				  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				  <!--<style>
                  .grecaptcha-badge{position:relative !important; right:0 !important; left:0 !important;}
                  </style>-->
				  @include('admin.inc.message')

				  <form class="form-wrap-1 form-type form-ani" role="form" method="POST" action="{{ url('/login') }}">
					  {{ csrf_field() }}
					  <h1 class="title-1 text-center">Sign in to your account</h1>

					  <div class="inrow">
						  <span><input type="text" name="email" class="form-control"/></span>
						  <label>Email Address</label>
					  </div>
					  <div class="inrow">
						  <span><input type="password" name="password" class="form-control"/></span>
						  <label>Password</label>
						  <input type="hidden" name="redirect" value="{{ url('topical-reports')}}">
					  </div>
					  <!--<div class="form-group">
                <div class="google-recaptcha">
                    <div class="g-recaptcha" data-callback="onSubmit"
                        data-sitekey="{{env('CAPTCHA_SITE_KEY')}}" data-size="invisible"></div>
                    <input type="hidden" title="Please verify this" class="required" name="keycode"
                        id="keycode">
                    <div id="cap-response" style="display:none; color:#F00;"></div>

                </div>
            </div>-->
					  <button type="submit" class="btn-2">Sign in</button>
					  <div class="links">
						  <a href="#">Forgot Password?</a>
					  </div>
				  </form>
			  </div>
		  </div>
	  </div><!-- /.modal -->
@endsection
