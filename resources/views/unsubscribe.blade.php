@extends('layouts.app')

@section('content')
            <div class="main-wrap">
                @include('inc.banner')

				<div class="container thanks-wrap " style="padding-top: 0px !important; ">
					<div>
					    <div class="img-text-wrap">
					        <div class="unc-img"><img src="http://fia.verz1.com/images/email-thanks.jpg" alt="" style="display: block; margin-left: auto; margin-right: auto;" /></div>
					        <div class="unc-detail">
                            <h3>Do you want to unsubscribe?</h3>
                            <p>If you unsubscribe, you will stop receiving our weekly newsletter</p>
                            <a class="btn-2 btn-unc" href="{{url('post-unsubscribe/'.$id)}}">Unsubscribe</a>
                            <a class="btn-2 btn-cancel" href="{{url('/')}}">Cancel</a>
                        </div>
					    </div>
					</div>
                </div>


            </div><!-- //main -->


@endsection
