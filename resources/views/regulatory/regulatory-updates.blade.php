@extends('layouts.app')

@section('content')

<div id="toppage" class="page">
    <div class="main-wrap">
        @include('inc.banner')
        <div class="filter-wrap fw-type">
            <div class="container">
                <div class="cw-1">
                    <label>Filter by</label>
                </div>
                <div class="cw-2">
                    <div class="cw-3 sl-country hideico">
                        <select class="selectpicker" data-live-search="true" data-actions-box="true" name="country[]" title="-- Country --" multiple>
                                <option data-content='<strong>COUNTRY</strong>'>COUNTRY</option>
                            <!--<option data-content='<img src="images/tempt/flag-afghanistan.jpg" alt="china" /> Afghanistan'> Afghanistan</option>-->
                            @foreach (getFilterCountry() as $country)
                            <option
                                data-content='<img src="{{ $country->country_image ?? '#' }}" alt="{{ $country->tag_name }}" /> {{ $country->tag_name }}'
                                value="{{ $country->id }}"> {{ $country->tag_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker" data-live-search="true" name="month">
                                <option value="">-- Months --</option>
                                @foreach (getFilterMonth() as $key => $month)
                                <option value="{{ $key+1 }}">{{ $month->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker" data-live-search="true" name="year">
                                <option value="">-- Year --</option>
                                @foreach (getFilterYear() as $year)
                                <option value="{{ $year->tag_name }}" @if($year->tag_name) @if($year->tag_name==date('Y')) selected @endif @endif>{{ $year->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker" data-live-search="true" name="topic">
                                <option value="">-- Topic --</option>
                                @foreach (getFilterTopic() as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker" data-live-search="true" name="stage">
                                <option value="">-- Stage --</option>
                                @foreach (getFilterStage() as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cw-5">
                        <a class="lk-back" href="#">Clear all</a>
                    </div>
                </div>
            </div>
        </div>
        @if(getRegulatoriesHighlight())
        @php
        $regulatory_highlight = getRegulatoriesHighlight();

        $other_highlight_array = [
        $regulatory_highlight->other_highlight1,
        $regulatory_highlight->other_highlight2,
        $regulatory_highlight->other_highlight3,
        $regulatory_highlight->other_highlight4,
        $regulatory_highlight->other_highlight5,
        ];

        $regulatory_main_highlight = getRegulatoryById($regulatory_highlight->main_highlight);
        @endphp
        <div class="bg-tempt">
            <div class="container space-1">
                <h1 class="title-1 text-center">Highlights</h1>
                <div class="row grid-4">
                    <div class="col-md-8">
                        <div class="box-4">
                            @if($regulatory_main_highlight)
                            <figure>@if(file_exists(str_replace(url('/').'/', '', getFilterCountryImage($regulatory_main_highlight->country_id))))<img src="@if($regulatory_main_highlight->country_id) {{ getFilterCountryImage($regulatory_main_highlight->country_id) }} @endif"
                                    alt="@if($regulatory_main_highlight->country_id){{  getFilterCountry($regulatory_main_highlight->country_id) }} @endif" />@endif</figure>
                            <div class="content">
                                <div class="text-1">
                                    <h3 class="title">{{ $regulatory_main_highlight->title }}</h3>
                                    <p class="date"><span
                                            class="country">@if($regulatory_main_highlight->country_id) {{ getFilterCountry($regulatory_main_highlight->country_id) }} @endif</span>
                                        | @if(getDateRegulatoryInner($regulatory_main_highlight->id)) {{ date('d m, Y', strtotime(getDateRegulatoryInner($regulatory_main_highlight->id))) }} @endif</p>
                                    {!! Illuminate\Support\Str::limit(strip_tags(getRegulatoryDescription($regulatory_main_highlight->id)), 800) !!}
                                </div>
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail"
                                href="{{ url('regulatory-details', $regulatory_main_highlight->slug) }}">View detail</a>
                            @endif
                        </div>
                        <div class="row eheight">
                            @for ($i = 0; $i < 2; $i++) @php
                            $regulatory_other_highlight=getRegulatoryById($other_highlight_array[$i]); @endphp
                            <div class="col-sm-6">
                                @if($regulatory_other_highlight)
                                <div class="box-4">
                                    <figure>@if(file_exists(str_replace(url('/').'/', '', getFilterCountryImage($regulatory_other_highlight->country_id))))<img
                                            src="@if($regulatory_other_highlight->country_id) {{ getFilterCountryImage($regulatory_other_highlight->country_id) }} @endif"
                                            alt="@if($regulatory_other_highlight->country_id) {{ getFilterCountry($regulatory_other_highlight->country_id) }} @endif" />@endif
                                    </figure>
                                    <div class="content">
                                        <div class="ecol">
                                            <h3 class="title">{{ $regulatory_other_highlight->title }}</h3>
                                            <p class="date"><span
                                                    class="country">@if($regulatory_other_highlight->country_id) {{ getFilterCountry($regulatory_other_highlight->country_id) }} @endif</span>
                                                | @if(getDateRegulatoryInner($regulatory_other_highlight->id)) {{ date('d m, Y', strtotime(getDateRegulatoryInner($regulatory_other_highlight->id))) }} @endif</p>
                                            {!! Illuminate\Support\Str::limit(strip_tags(getRegulatoryDescription($regulatory_other_highlight->id)),
                                            250) !!}
                                        </div>
                                        <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                                    </div>
                                    <a class="detail" href="{{ url('regulatory-details', $regulatory_other_highlight->slug) }}">View detail</a>
                                </div>
                                @endif
                            </div>
                            @endfor
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row eheight">
                            @for ($i = 2; $i < count($other_highlight_array); $i++) @php
                            $regulatory_other_highlight=getRegulatoryById($other_highlight_array[$i]); @endphp
                            <div class="col-md-12 col-sm-6">
                                @if($regulatory_other_highlight)
                                <div class="box-4">

                                    <figure>@if(file_exists(str_replace(url('/').'/', '', getFilterCountryImage($regulatory_other_highlight->country_id))))<img src="@if($regulatory_other_highlight->country_id) {{ getFilterCountryImage($regulatory_other_highlight->country_id) }} @endif"
                                            alt="@if($regulatory_other_highlight->country_id) {{ getFilterCountry($regulatory_other_highlight->country_id) }} @endif" />@endif
                                    </figure>
                                    <div class="content">
                                        <div class="ecol">
                                            <h3 class="title">{{ $regulatory_other_highlight->title }}</h3>
                                            <p class="date"><span
                                                    class="country">@if($regulatory_other_highlight->country_id) {{ getFilterCountry($regulatory_other_highlight->country_id) }} @endif</span>
                                                | @if(getDateRegulatoryInner($regulatory_other_highlight->id)) {{ date('d m, Y', strtotime(getDateRegulatoryInner($regulatory_other_highlight->id))) }} @endif</p>
                                            {!! Illuminate\Support\Str::limit(strip_tags(getRegulatoryDescription($regulatory_other_highlight->id)), 200)
                                            !!}
                                        </div>
                                        <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                                    </div>
                                    <a class="detail" href="{{ url('regulatory-details', $regulatory_other_highlight->slug) }}">View detail</a>
                                </div>
                                @endif
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container space-1 search-results">
            <h1 class="title-1 text-center">Latest Updates</h1>
            @php
            $regulatory = getRegulatories()->splice(0, setting()->pagination_limit ?? 8);
            @endphp
            @if($regulatory)
            <input type="hidden" name="min_load" value="{{ setting()->pagination_limit ?? 8 }}">
            <div class="grid-2 eheight clearfix">
                @foreach ($regulatory as $value)
                @php
                    $regulatory = getRegulatoryData($value->parent_id);
                @endphp
                @if($regulatory)
                <div class="item mbox">
                    <div class="box-4">
                        <figure>@if(file_exists(str_replace(url('/').'/', '', getFilterCountryImage($regulatory->country_id))))<img src="@if($regulatory->country_id) {{ getFilterCountryImage($regulatory->country_id) }} @endif" alt="@if($regulatory->country_id) {{ getFilterCountry($regulatory->country_id) }} @endif flag" />@endif</figure>
                        <div class="content">
                            <div class="ecol">
                                <h3 class="title">{{ $value->title }}</h3>
                                <p class="date"><span class="country">@if($regulatory->country_id) {{ getFilterCountry($regulatory->country_id) }} @endif</span> |
                                    @if($value->regulatory_date) {{ date('M d, Y', strtotime($value->regulatory_date)) }} @endif</p>
                                    {!! Illuminate\Support\Str::limit(strip_tags($value->description), 250) !!}
                            </div>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail load-more-regulatory" href="@if($regulatory->slug) {{ url('regulatory-details', $regulatory->slug) . '?id=' . $value->id }} @else javascript:void(0) @endif" data-id="{{ $value->id }}">View detail</a>
                    </div>
                </div>
                @endif
                @endforeach
                <div class="more-wrap"><button class="btn-4 load-more-regulatory"> Load more <i
                    class="fas fa-angle-double-down"></i></button></div>
            </div>

                @endif

        </div>
        @endif
    </div><!-- //main -->

</div><!-- //page -->
<script>
    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("a.lk-back").on("click", function () {
            var d = new Date();
            $("select[name='country[]']").val('');
            $("select[name='month']").val('');
            $("select[name='year']").val(d.getFullYear());
            $("select[name='topic']").val('');
            $("select[name='stage']").val('');
            $('.selectpicker').selectpicker('refresh');
            getSearchResult();
        });

        var country_array = [];
        var month_array = [];
        var year_array = [];
        var topic_array = [];
        var stage_array = [];

        $("select[name='country[]']").on("change", function () {
            getSearchResult();
        });

        $("select[name='month']").on("change", function () {
            getSearchResult();
        });

        $("select[name='year']").on("change", function () {
            getSearchResult();
        });

        $("select[name='topic']").on("change", function () {
            getSearchResult();
        });

        $("select[name='stage']").on("change", function () {
            getSearchResult();
        });

        function getSearchResult(option_type) {
            country_array.push($("select[name='country[]']").val());
            month_array.push($("select[name='month']").val());
            year_array.push($("select[name='year']").val());
            topic_array.push($("select[name='topic']").val());
            stage_array.push($("select[name='stage']").val());

            $.ajax({
                type: 'GET',
                url: "{{ url('/regulatory-details-search') }}",
                data: {
                    country: country_array,
                    month: month_array,
                    year: year_array,
                    topic: topic_array,
                    stage: stage_array,
                    option_type: option_type,
                    _token: CSRF_TOKEN,
                },
                cache: false,
                async: false,
                success: function (data) {

                    $(".search-results").html(data);
                    $(".bg-tempt").addClass("hide");
                    showMore();
                }
            });
            country_array = [];
            month_array = [];
            year_array = [];
            topic_array = [];
            stage_array = [];
            $('.eheight').each(function() {
                //alert($(this).find('.ecol').html());
                $(this).find('.ecol').matchHeight();
            });

        }

        counter = 2;
        $("body").on("click", "button.load-more-regulatory", function() {
            var id = $("a.load-more-regulatory:last").attr("data-id");
            var min_load = $("input[name='min_load']").val();
            $.ajax({
                type: 'POST',
                url: "{{ url('load-more-regulatories') }}",
                data: {
                    id: id,
                    counter: counter,
                    min_load: min_load,
                    _token: CSRF_TOKEN,
                },
                cache: false,
                async: false,
                success: function (data) {
                    $(".search-results").html('');
                    $(".search-results").append(data);
                }
            });
            $('.eheight').each(function() {
                //alert($(this).find('.ecol').html());
                $(this).find('.ecol').matchHeight();
            });
            counter++;
        });
    });

</script>

@endsection
