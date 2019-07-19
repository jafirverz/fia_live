@extends('layouts.app')
@section('content')

            <div class="main-wrap">
				@include('inc.banner')
				<div class="container space-1">
					<h1 class="title-1" style="margin-bottom: 0;">{{ $event->event_title }}</h1>
					<p class="date-post">{{date("D",strtotime($event->event_date))}}  |  {{ date("h:i A",strtotime($event->event_date)) }}</p>
					<article class="document">
						<figure><img src="{{asset($event->event_image)}}" alt="" /></figure>
						{!! $event->description!!}
					</article>

				</div>

            </div>
@endsection
