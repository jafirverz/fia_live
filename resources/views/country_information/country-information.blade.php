@extends('layouts.app')

@section('content')
<div id="toppage" class="page">

    <div class="main-wrap">
        @include('inc.banner')
        <div class="container space-1 mheight">
            <h1 class="title-1 text-center">Search for Country Information</h1>
            <form action="{{ url('country-information-details') }}?country={{ $_GET['country'] ?? '' }}&category={{ $_GET['category'] ?? '' }}" class="search-wrap-1 clearfix" method="GET">
                <div class="col-1">
                    I am searching for
                </div>
                <div class="col-2 sl-country hideico">
                    <select data-size="5" name="country" class="selectpicker" data-live-search="true">
                        <option data-content='<strong>COUNTRY</strong>'>COUNTRY</option>
                        <!--<option data-content='<img src="images/tempt/flag-afghanistan.jpg" alt="china" /> Afghanistan'> Afghanistan</option>-->
                        @foreach (getFilterCountryInformation() as $country)
                        <option data-content='<img src="{{ $country->country_image ?? '#' }}" alt="{{ $country->tag_name }}" /> {{ $country->tag_name }}' value="{{ $country->tag_name }}" @if($country->tag_name=='Singapore' || $country->tag_name=='SG') selected @endif>{{ $country->tag_name }}</option>
                        @endforeach
                    </select>
                    <span class="sp-text">’s information</span>
                </div>
                <div class="col-3">regarding
                </div>
                <div class="col-4">
                    <select data-size="5" name="category" class="selectpicker" data-live-search="true">
                        @foreach (getFilterCategory() as $category)
                        <option value="{{ $category->tag_name }}">{{ $category->tag_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5">
                    <button type="submit" class="btn-2">Go</button>
                </div>
            </form>
        </div>

    </div><!-- //main -->

</div><!-- //page -->
@endsection
