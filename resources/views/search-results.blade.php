@extends('layouts.app')

@section('content')
            <div class="main-wrap">   
				@include('inc.banner')
				<div class="container space-1">
					<h1 class="title-1 text-center">Search Results</h1>
					<div class="intro-1 space-3">
                    @if(isset($_REQUEST['search_content']))
						<p>Your search for {{$_REQUEST['search_content']}} has brought back these results</p>
                    @endif
					</div>
                    @if(count($informations)>0)
					<div class="box-5 clearfix mlist-wrap">
						<figure>
							<div class="image"><img src="{{asset('images/tempt/ico-1.png')}}" alt="" /></div>
						</figure>
						<div class="content">
							<h2>Country information</h2>
							<ul class="mlist" data-num="5">
                            @foreach($informations as $info)
								<li class="mlist-line"><a href="{{ $info['link']}}">{{ strip_tags($info['content'])}}</a></li>
                            @endforeach
														</ul>
						</div>
						<a class="see-all" href="#">Load more</a>
					</div>
                    @endif
                    @if(count($regulatories)>0)
					<div class="box-5 clearfix mlist-wrap">
						<figure>
							<div class="image"><img src="{{asset('images/tempt/ico-2.png')}}" alt="" /></div>
						</figure>
						<div class="content">
							<h2>Regulatory updates</h2>
							<ul class="mlist" data-num="5">
                            @foreach($regulatories as $info)
								<li class="mlist-line"><a href="{{ $info['link']}}">{{ strip_tags($info['content'])}}</a></li>
                            @endforeach
							</ul>
						</div>
						<a class="see-all" href="#">Load more</a>
					</div>
                    @endif
                    @if(count($resources)>0)
					<div class="box-5 clearfix mlist-wrap">
						<figure>
							<div class="image"><img src="{{asset('images/tempt/ico-3.png')}}" alt="" /></div>
						</figure>
						<div class="content">
							<h2>resources</h2>
							<ul class="mlist" data-num="5">
                            @foreach($resources as $info)
								<li class="mlist-line"><a href="{{ $info['link']}}">{{ strip_tags($info['content'])}}</a></li>
                            @endforeach
							</ul>
						</div>
						<a class="see-all" href="#">Load more</a>
					</div>
                    @endif
                    @if(count($others)>0)
					<div class="box-5 clearfix mlist-wrap">
						<figure>
							<div class="image"><img src="{{asset('images/tempt/ico-4.png')}}" alt="" /></div>
						</figure>
						<div class="content">
							<h2>others</h2>
                            <ul class="mlist" data-num="5">
							@foreach($others as $info)
								<li class="mlist-line"><a href="{{ $info['link']}}">{{ strip_tags($info['content'])}}</a></li>
                            @endforeach
                            </ul>
						</div>
						<a class="see-all" href="#">Load more</a>
					</div>
                    @endif
				</div>
                
            </div><!-- //main -->
            
@include('inc.feedback-form')
@endsection
