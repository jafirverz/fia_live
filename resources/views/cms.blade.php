@extends('layouts.app')

@section('content')
            <div class="main-wrap">   
				@include('inc.banner')
				<div class="container @if($page->slug!='thank-you') space-1 @else thanks-wrap @endif">
					
						<a class="fas fa-angle-double-left lk-back" href="">Back</a>
						{!! $page->contents!!}
					
				</div>
                @if($page->slug=='about-us' && !Auth::check())
				<div class="box-1">
					<div class="container">
						<div class="tb-col break-991">
							<div class="col">
								<h3>Get Access to our Regulatory Updates, Country Information and Resources with Regulatory Hub Subscription</h3>
							</div>
							<div class="col">
								<a class="btn-3" href="register.html">REGISTER NOW!</a>
							</div>
						</div>
					</div>
				</div>
                @endif
            </div><!-- //main -->
            

@endsection
