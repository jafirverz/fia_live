@extends('layouts.app')
@php
    $contents = getCountryInformationBasedOnDetails($_GET['country'], $_GET['category']);
@endphp
@section('content')
<div id="toppage" class="page">


            <div class="main-wrap">
                @include('inc.breadcrumb');
				<div class="tempt-1">
					<div class="container">
						<div class="clearfix">
							<div class="col-1">
								<div class="sl-wrap">
									<a class="btn-control" href="#nav">Select Country</a>
									<div id="nav" class="nav-content">
										<div class="btn-sort clearfix">
											<a class="active" href="#">A - Z</a>
											<a href="#">Z - A</a>
										</div>
										<ul class="nav-list">
											<!--<li><a href="#">Afghanistan</a></li>-->
                                            @foreach (getFilterCountry() as $country)
                                                <li @if($country->tag_name==$_GET['country']) class="active" @endif><a href="{{ url('country-information-details') }}?country={{
                                            $country->tag_name }}&category={{ $_GET['category'] ?? '' }}">{{ $country->tag_name }}</a></li>
                                                <ul>
                                                @foreach (getFilterCategory() as $category)
                                                <li @if($category->tag_name==$_GET['category'] && $country->tag_name==$_GET['country']) class="active" @endif><a href="{{ url('country-information-details') }}?country={{
                                                    $country->tag_name }}&category={{ $category->tag_name }}">{{ $category->tag_name }}</a></li>
                                                @endforeach
                                                </ul>
                                            @endforeach
										</ul>
									</div>
								</div>
                            </div>
							<div class="col-2">	
                                @if(Auth::check())
								<div class="tb-col title-wrap-1 break-640">
									<div class="col">
										<h1 class="title-1">{{ $_GET['country'] ?? '' }}</h1>
										<h2 class="title-2">{{ $_GET['category'] ?? '' }}</h2>
									</div>
									<div class="col">
										<a href="#" class="btn-4">EXPORT <i class="fas fa-file-export"></i></a>
									</div>
                                </div>
                                @if($contents)
                                @foreach ($contents as $key => $content)
								<div class="box-3 noheight @if ($loop->first) open @endif">
									<a class="head-box" data-height="0" href="#country-{{ $key }}">
										{{ $content->information_title }}
									</a>
									<div class="content-box" id="country-{{ $key }}">
										<div class="document">
											{!! $content->information_content !!}
										</div>
									</div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @else
                            @include('inc.signin')
                            @endif
						</div>
					</div>

				</div>

            </div><!-- //main -->

        </div><!-- //page -->
@endsection
