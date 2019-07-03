@extends('layouts.app')

@section('content')
            <div class="main-wrap">   
				@include('inc.banner');
				<div class="container space-1">
					
						<a class="fas fa-angle-double-left lk-back" href="">Back</a>
						{!! $page->contents!!}
					
				</div>
                @if($page->slug=='about-us')
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
