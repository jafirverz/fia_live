@extends('layouts.app')
@section('content')
<div class="main-wrap">   
				@include('inc.banner')
				<div class="container space-1">
					<h1 class="title-1 text-center">Search Results</h1>
					<div id="search-list" class="masony grid-2" data-num="8" data-load="#btn-load">
						
                        @if($regulatories)
                    @foreach($regulatories as $regulatory)
						<div class="item">
							<div class="box-4">
								<figure><img src="{{getFilterCountryImage($regulatory->country_id)}}" alt="{{getFilterCountry($regulatory->country_id)}} flag" /></figure>
								<div class="content">
									<h3 class="title">{{$regulatory->title}}</h3>
									<p class="date"><span class="country">{{getFilterCountry($regulatory->country_id)}}</span>  |  {{ $regulatory->created_at->format('M d, Y') }}</p>
									<p>{!! substr(strip_tags($regulatory->description),0,120) !!}</p>
									<p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
								</div>
								<a class="detail" href="{{url('regulatory-details',$regulatory->slug)}}">View detail</a>
							</div>						
						</div>
					@endforeach 
                    @endif  	
						<!-- no loop this element --> <div class="grid-sizer"></div> <!-- no loop this element -->		
					</div>
					<div class="more-wrap"><button id="btn-load" class="btn-4 load-more"> Load more <i class="fas fa-angle-double-down"></i></button></div>
					
				</div>
                
            </div>
@endsection
