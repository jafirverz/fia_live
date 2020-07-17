@extends('layouts.app')
@section('content')

            <div class="main-wrap">
				@include('inc.banner')
				<div class="container space-1">
					<h1 class="title-1" style="margin-bottom: 0;">{{ $thinkingPiece->thinking_piece_title }}</h1>
					<p class="date-post">{{date("jFY",strtotime($thinkingPiece->thinking_piece_date))}}  |  {{ date("h:i A",strtotime($thinkingPiece->thinking_piece_date)) }}</p>
					<article class="document">
						<figure><img src="{{asset($thinkingPiece->thinking_piece_image)}}" alt="" /></figure>
						{!! $thinkingPiece->description!!}
					</article>

				</div>

            </div>
@endsection
