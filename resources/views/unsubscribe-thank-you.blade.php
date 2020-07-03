@extends('layouts.app')

@section('content')
            <div class="main-wrap">
                @include('inc.banner')

				<div class="container thanks-wrap " style="padding-top: 0px !important; ">
					{!! $page->contents!!}
                </div>


            </div><!-- //main -->


@endsection
