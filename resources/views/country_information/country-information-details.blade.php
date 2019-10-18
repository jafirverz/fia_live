@extends('layouts.app')

@php

$contents = getCountryInformationBasedOnDetails($_GET['country'], $_GET['category']);

//dd($contents);

@endphp

@section('content')

<div id="toppage" class="page">

    <div class="main-wrap">

        @include('inc.banner')
        <div class="@if(Auth::check()) tempt-1 @endif">
            @if($contents)

            <div class="container">

                <div class="clearfix">

                    @if(Auth::check())

                    <div class="col-1">

                        <div class="sl-wrap">

                            <a class="btn-control" href="#nav">Select Country</a>

                            <div id="nav" class="nav-content">

                                <ul class="btn-sort clearfix">
                                    <li class="active"><a data-toggle="tab" href="#tab-1">A - Z</a></li>
                                    <li><a data-toggle="tab" href="#tab-2">Z - A</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <ul class="nav-list">
                                            @foreach (getFilterCountryInformation() as $country)
                                            <li @if($country->tag_name==$_GET['country']) class="active" @endif>
                                                <a href="{{ url('country-information-details') }}?country={{
                                                    $country->tag_name }}&category={{ $_GET['category'] ?? '' }}">{{ $country->tag_name }}</a>
                                                <ul>
                                                    @foreach (getFilterCategory() as $category)
                                                    <li @if($category->tag_name==$_GET['category'] &&
                                                        $country->tag_name==$_GET['country']) class="active" @endif>
                                                        <a href="{{ url('country-information-details') }}?country={{
                                                                $country->tag_name }}&category={{ $category->tag_name }}">{{ $category->tag_name }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                            @endforeach

                                        </ul>

                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                        <ul class="nav-list">
                                            @foreach (getFilterCountryInformation()->reverse() as $country)
                                            <li @if($country->tag_name==$_GET['country']) class="active" @endif>
                                                <a href="{{ url('country-information-details') }}?country={{
                                                    $country->tag_name }}&category={{ $_GET['category'] ?? '' }}">{{ $country->tag_name }}</a>
                                                <ul>
                                                    @foreach (getFilterCategory() as $category)
                                                    <li @if($category->tag_name==$_GET['category'] &&
                                                        $country->tag_name==$_GET['country']) class="active" @endif>
                                                        <a href="{{ url('country-information-details') }}?country={{
                                                                $country->tag_name }}&category={{ $category->tag_name }}">{{ $category->tag_name }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-2">



                        <div class="tb-col title-wrap-1 break-640">

                            <div class="col">

                                <h1 class="title-1">{{ ucfirst($_GET['country']) ?? '' }}</h1>

                                <h2 class="title-2">{{ $_GET['category'] ?? '' }}</h2>

                            </div>

                            <div class="col">

                                <a href="{{ url('country-information-print') }}?country={{ $_GET['country'] ?? '' }}&category={{ $_GET['category'] ?? '' }}"

                                    class="btn-4 export_link" target="_blank">EXPORT <i

                                        class="fas fa-file-export"></i></a>

                            </div>

                        </div>

                        @if($contents)

                        @foreach ($contents as $key => $content)

                        <div class="box-3 noheight @if ($loop->first) open @endif" data-id="{{ $content->id }}">

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

            @endif

        </div>



    </div><!-- //main -->



</div><!-- //page -->

@include('inc.feedback-form')

<script>

    var slug =

        "{{ url('country-information-print') }}?country={{ $_GET['country'] ?? '' }}&category={{ $_GET['category'] ?? '' }}";



    var array_list = [];

    hasClassOpen();

    $("div.box-3").on("click", function () {

        if ($(this).hasClass('open')) {

            array_list.push($(this).attr('data-id'));

        } else {

            array_list.pop($(this).attr('data-id'));

        }

        $("a.export_link").attr("href", slug + '&id=' + array_list.reverse().join());

    });



    function hasClassOpen() {

        array_list.push($("div.box-3.open").attr('data-id'));

        $("a.export_link").attr("href", slug + '&id=' + array_list.join());

    }



</script>

@endsection

