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
									<select data-live-search="true" name="topic" onchange="this.form.submit()" class="selectpicker">
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
							<a class="head-box" data-height="120" href="#report-{{ $report->id }}">@php $topics=json_decode($report->topical_id); @endphp {{getTopics($topics)}} : {{$report->title}}</a>
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
									@php
									$report_pdf=explode(".",$report->pdf,-1);
									$report_pdf=explode("/",$report_pdf[0]);
									$report_pdf=explode("_",$report_pdf[2],-1);

									@endphp
                                     @if(Auth::check())
										@if($report->pdf!="")<a class="btn-4" href="{{url(asset($report->pdf))}}" target="_blank"><i class="far fa-file-pdf"></i> {{implode(" ",$report_pdf)}}</a>@endif
                                     @else
                                     <a href="#find-pp" class="btn-4" data-toggle="modal"><i class="far fa-file-pdf"></i> {{implode(" ",$report_pdf)}}</a>
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
<script>
    var id = '{{ $_GET["id"] ?? "" }}';

    if(id)
    {
        $('div.box-3').removeClass("open");
        $('div.box-3 a[href="#'+id+'"]').parent('div.box-3').addClass('open');
    }

    $(document).ready(function() {
        if(id)
        {
            setTimeout(function() {
                $('html, body').animate({
                    scrollTop: $('div.box-3 a[href="#'+id+'"]').offset().top
                }, 1500);
            }, 1000);
        }
    });
</script>
@if ($errors->any())
<script type="text/javascript">
    $(window).on('load',function(){
        $('#find-pp').modal('show');
    });
</script>
@endif
@include('inc.sign-in-form')
@endsection
