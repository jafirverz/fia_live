@extends('layouts.app')

@section('content')
      <div class="main-wrap">   
				@include('inc.banner');
				<div class="filter-wrap fw-type">
					<div class="container">						
						<div class="tb-col break-480">
							<div class="col">
								<label>Filter by</label>
								<div class="w-1">
									<select class="selectpicker">
										<option>Month</option>
										<option>January</option>
										<option>February</option>
										<option>March</option>
										<option>April</option>
										<option>May</option>
										<option>June</option>
										<option>July</option>
										<option>August</option>
										<option>September</option>
										<option>October</option>
										<option>November</option>
										<option>December</option>
									</select>
								</div>
								<div class="w-2">
									<select class="selectpicker">
										<option>Year</option>
										<option>2019</option>
										<option>2020</option>
										<option>2021</option>
									</select>
								</div>
							</div>
							<div class="col">
								<a class="lk-back" href="#">Clear all</a>
							</div>
						</div>
					</div>
				</div>
				<div class="container space-1">
					
					<h1 class="title-1 text-center">Upcoming Events</h1>
					<div id="events" class="masony" data-num="5" data-load="#btn-load">
						@foreach($events as $event)
						<div class="grid-1 item">
							<div class="tb-col">
								<div class="col date-col">
									<span class="month">{{date("F",strtotime($event->event_date))}}</span> <strong>{{date("d",strtotime($event->event_date))}}</strong> {{date("Y",strtotime($event->event_date))}}
								</div>
								<div class="col content-col">
									<div class="content">								
										<h2>{{$event->event_title}}</h2>
										<p class="date-post">{{date("D",strtotime($event->event_date))}}  |  2:00 PM</p>
										<p>{{$event->event_address}}</p>
										<span class="btn-4">See More <i class="fas fa-angle-double-right"></i></span>
									</div>
								</div>
							</div>
							<a href="{{url('event/details/'.$event->id)}}" class="more">Read more</a>
						</div>
                        @endforeach
						
						<!-- no loop this element --> <div class="grid-sizer"></div> <!-- no loop this element -->					
					</div>
					<div class="more-wrap"><button id="btn-load" class="btn-4 load-more"> Load more <i class="fas fa-angle-double-down"></i></button></div>
				</div>
                
            </div>
@endsection
