@extends('layouts.app')

@section('content')

<!-- Content Containers -->

	<div class="main-container">

		@include('inc.breadcrumb-banner')

       

		<!-- Section -->

		<div class="fullcontainer bg-img" style="background-image:url(images/bg4.jpg);">

			<div class="fullcontainer bg-img-tl" style="background-image:url(images/bg1.png);">

				<div class="inner-container-md">

					<div class="container">
                    <div class="cont-sm">

							<div class="pod-search-tool-bar">
							<div class="row">
{!! $page->contents !!}
						</div></div></div>
                        
                        <h2 class="text-center"><span>Check out our</span><strong>Latest Events</strong></h2>

						<div class="cont-sm">

							<div class="pod-search-tool-bar">

								<div class="row">

                                

                                {!! Form::open(['url' => '/search', 'method' => 'post']) !!}

                                {{ csrf_field() }}

									<div class="col-sm-6">

										<div class="tool-box">

											<label>Search:</label>

											<input name="search_content" type="text" class="form-control alt" placeholder="BGST Online">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="tool-box">

											<label>Filter by:</label>

                                             <?php $event_types = \DB::table('event_types')->orderBy('event_type_title','asc')->get();?>

											<select onchange="this.form.submit()" class="selectpicker alt" name="eventtype" data-width="100%" data-style="" title="Filter by">

                                                <option value="all"> See All </option>

                                                @foreach($event_types as $type)

												<option value="{{ $type->id }}">{{ $type->event_type_title }}</option>

                                                @endforeach

											</select>

										</div>

									</div>

                                    <input type="hidden" value="1" name="search" />

                                   <input type="submit" style="position: absolute; left: -9999px"/>

                                {!! Form::close() !!}

								</div>

							</div>

							<div class="pod-list events-pods">

								<div class="row">

                                @if(count($events)>0)

									@foreach($events as $event)



                                   <?php $event_type = \DB::table('event_types')->where('id', $event->type)->get();?>



                                    @if($event->speaker)



								   <?php 



								    



									$speaker=json_decode($event->speaker);



									$sp="";

									$n=0;

										foreach($speaker as $key=>$value)



										{

										$n++;

										$speakers  = \DB::table('teachers')->select('teacher_name')->where('id',$value)->get();



										if($speakers->count())



										$sp.=$speakers[0]->teacher_name;

										

										if(count($speaker)!=$n)

										$sp.=', ';

										}



										?>



                                    @endif

									<div class="col-sm-6">

										<div class="pod-box"><a href="{{ url('events/details/' . $event->id) }}" class="img-effect">

											<div class="image-holder"><figure><img src="{!! asset($event->event_image) !!}" class="responsive" height="483" alt="BIBLICAL GRADUATE SCHOOL OF THEOLOGY."/></figure></div>

											<div class="pod-info-holder">

												<div class="pod-info equalheight height736">

													<h5> 

                                                     @if($event_type->count())

                                                     {{ $event_type[0]->event_type_title }}:

                                                     @endif

                                                    <strong>{{ $event->title }}</strong></h5>

													<h5>Speaker: 

                                                     @if($event->speaker)

                                                    <strong>{{ $sp  }}</strong>

                                                    @endif

                                                    </h5>
													@if($event->start_date)
													<!--<label>Start: </label>--> {{ date("F j Y",strtotime($event->start_date)) }}   |   {{ date("h:m A",strtotime($event->start_date)) }}<br>
													@endif
                                                    @if($event->end_date)
                                                    <!--<label>End: </label>--> {{ date("F j Y",strtotime($event->end_date)) }}   |   {{ date("h:m A",strtotime($event->end_date)) }}<br>
                                                    @endif

                                                      @if($event->oth_date!=null)

                                                   <?php /*?><label>Other Date: </label> {{ date("F j Y",strtotime($event->oth_date)) }}<br><?php */?>

                                                    @endif

                                                    <span class="badge">{{ ($event->paid_event==1)? 'PAID' : 'FREE' }}</span></p>

												</div>

												<div class="text-center"><span class="button btn-light">More Info</span></div>

											</div>

											</a></div>

									</div>

                                    @endforeach

                                  @else

                                  No records found.

                                  @endif

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- Section END --> 

	</div>

	<!-- Content Containers END -->



@endsection

