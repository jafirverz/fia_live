@extends('layouts.app')

@section('content')
            <div class="main-wrap">
                @include('inc.banner')

				<div class="container @if(in_array($page->slug,['thank-you','email-verification','resend-email-verification','unsubscribed']))  thanks-wrap @else space-1 @endif">
                        @if($page->slug=='verified-thank-you' && $page->slug=='account-verified')
                        <div class="document" style="margin:0px;"><a class="fas fa-angle-double-left lk-back" onclick="window.history.back(1)">Back</a></div>
                        @endif
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
								<a class="btn-3" href="{{ url('register')}}">REGISTER NOW!</a>
							</div>
						</div>
					</div>
				</div>
                @endif
            </div><!-- //main -->


@endsection
