@extends('layouts.app')

@section('content')
<div class="main-wrap">
	@include('inc.banner')
	<div class="filter-wrap fw-type">
		<div class="container">
			<div class="tb-col break-480">
				<form name="filter" method="get" action="{{ url('/thinking-piece/search')}}"
					enctype="multipart/form-data">
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<div class="col">
						<label>Filter by</label>
						<div class="w-1">
							<select data-live-search="true" onchange="this.form.submit()" name="month"
								class="selectpicker">
								<option value="">Month</option>
								@foreach(getMonthList() as $key=>$value)
								<option @if(request()->get('month')==$key) selected="selected" @endif
									value="{{$key}}">{{$value}}</option>
								@endforeach
							</select>
						</div>
						<div class="w-2">

							<select data-live-search="true" onchange="this.form.submit()" name="year"
								class="selectpicker">
								<option value="">Year</option>
								@foreach(getYearList() as $year)
								<option @if(request()->get('year')==$year) selected="selected" @endif
									value="{{$year}}">{{$year}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</form>
				<div class="col">
					<a class="lk-back" href="{{url('thinking-piece')}}">Clear all</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container space-1">

		<h1 class="title-1 text-center">Thinking Piece</h1>
		<div id="events" class="masony" data-num="{{ setting()->pagination_limit }}" data-load="#btn-load">
			@foreach($thinkingPieces as $thinkingPiece)
			<div class="grid-1 item gridimg">
				<div class="tb-col break-560">
					<div class="col bg">
						<img class="bgimg" src="{{ asset($thinkingPiece->thinking_piece_image) }}" alt="" />
					</div>
					<div class="col content-col">
						<div class="content">
							<h2>{{$thinkingPiece->thinking_piece_title}}</h2>
							<p class="date-post">{{date("d F Y",strtotime($thinkingPiece->thinking_piece_date))}}</p>
							<p>
								@if (strlen($thinkingPiece->description) > 200)
								<?php $pos=strpos($thinkingPiece->description, ' ', 200); ?>
								{!! substr($thinkingPiece->description,0,$pos ) . '...'; !!}
								@else
								{!!$thinkingPiece->description!!}
								@endif
							</p>
							<span class="btn-4">See More <i class="fas fa-angle-double-right"></i></span>
						</div>
					</div>
				</div>
				@php $thinking_piece_title=str_replace(" ","-",$thinkingPiece->thinking_piece_title);@endphp
				<a href="{{url('thinking-piece/'.$thinkingPiece->slug)}}" class="more">Read more</a>
			</div>
			@endforeach

			<!-- no loop this element -->
			<div class="grid-sizer"></div> <!-- no loop this element -->
		</div>
		@if(count($thinkingPieces)>setting()->pagination_limit)
		<div class="more-wrap"><button id="btn-load" class="btn-4 load-more"> Load more <i
					class="fas fa-angle-double-down"></i></button></div>
		@endif
	</div>

</div>
@endsection