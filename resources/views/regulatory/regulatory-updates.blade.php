@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        @include('inc.banner');
        @include('inc.breadcrumb');
        <div class="filter-wrap fw-type">
            <div class="container">
                <div class="cw-1">
                    <label>Filter by</label>
                </div>
                <div class="cw-2">
                    <div class="cw-3 sl-country hideico">
                        <select class="selectpicker" data-actions-box="true" name="country[]" multiple>
                            <!--<option data-content='<img src="images/tempt/flag-afghanistan.jpg" alt="china" /> Afghanistan'> Afghanistan</option>-->
                            @foreach (getFilterCountry() as $country)
                            <option
                                data-content='<img src="{{ $country->country_image ?? '#' }}" alt="{{ $country->tag_name }}" /> {{ $country->tag_name }}' value="{{ $country->id }}" > {{ $country->tag_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker" name="month">
                                <option value="">-- Month --</option>
                                @foreach (getFilterMonth() as $month)
                                <option value="{{ $month->tag_name }}">{{ $month->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker" name="year">
                                <option value="">-- Year --</option>
                                @foreach (getFilterYear() as $year)
                                <option value="{{ $year->tag_name }}">{{ $year->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker" name="topic">
                                <option value="">-- Topic --</option>
                                @foreach (getFilterTopic() as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker" name="stage">
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
        <div class="bg-tempt">
            <div class="container space-1">
                <h1 class="title-1 text-center">Highlights</h1>
                <div id="list-1" class="masony grid-4" data-num="8" data-load="#btn-load-1">

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
                    <div class="item  @if($regulatory_highlight->main_highlight) w-1 @endif">
                        @if($regulatory_main_highlight)
                        <div class="box-4">
                            <figure><img src="{{ getFilterCountryImage($regulatory_main_highlight->country_id) }}" alt="Laos flag" /></figure>
                            <div class="content">
                                <h3 class="title">{{ $regulatory_main_highlight->title }}</h3>
                                <p class="date"><span
                                        class="country">{{ getFilterCountry($regulatory_main_highlight->country_id) }}</span>
                                    | {{ $regulatory_main_highlight->created_at->format('d m Y') }}</p>
                                {!! Illuminate\Support\Str::limit($regulatory_main_highlight->description, 800) !!}
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail"
                                href="{{ url('regulatory-details', $regulatory_main_highlight->slug) }}">View detail</a>
                        </div>
                        @endif
                    </div>
                    @endif
                    @if($regulatory_highlight)
                    @php

                    @endphp
                    @endif
                    @for ($i = 0; $i < count($other_highlight_array); $i++) @php
                        $regulatory_other_highlight=getRegulatoryById($other_highlight_array[$i]); @endphp <div
                        class="item">
                        @if($regulatory_other_highlight)
                        <div class="box-4">

                            <figure><img src="images/tempt/flag-laos.jpg" alt="Laos flag" /></figure>
                            <div class="content">
                                <h3 class="title">{{ $regulatory_other_highlight->title ?? '' }}</h3>
                                <p class="date"><span class="country"></span>{{ getFilterCountry($regulatory_main_highlight->country_id) }} |
                                    {{ isset($regulatory_other_highlight->created_at) ?$regulatory_other_highlight->created_at->format('d m Y') : '' }}
                                </p>
                                {!! Illuminate\Support\Str::limit($regulatory_other_highlight->description ?? '', 200)
                                !!}
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail"
                                href="{{ url('regulatory-details', $regulatory_other_highlight->slug ?? '#') }}">View
                                detail</a>

                        </div>
                        @endif
                </div>
                @endfor
                <!-- no loop this element -->
                <div class="grid-sizer"></div> <!-- no loop this element -->
            </div>
            <div class="more-wrap"><button id="btn-load-1" class="btn-4 load-more"> Load more <i
                        class="fas fa-angle-double-down"></i></button></div>
        </div>
    </div>
    <div class="container space-1">
        <h1 class="title-1 text-center">Latest Updates</h1>
        <div id="list-2" class="masony grid-2" data-num="8" data-load="#btn-load-2">
            @php
            $regulatory = getRegulatories();
            @endphp
            @if($regulatory)
            @foreach ($regulatory as $value)
            <div class="item">
                <div class="box-4">
                    <figure><img src="{{ getFilterCountryImage($value->country_id) }}" alt="thailand flag" /></figure>
                    <div class="content">
                        <h3 class="title">{{ $value->title }}</h3>
                        <p class="date"><span class="country">{{ getFilterCountry($value->country_id) }}</span> |
                            {{ $value->created_at->format('M d, Y') }}</p>
                        {!! Illuminate\Support\Str::limit($value->description, 400) !!}
                    </div>
                    <a class="detail" href="{{ url('regulatory-details', $value->slug) }}">View detail</a>
                </div>
            </div>
            @endforeach
            @endif
            <!-- no loop this element -->
            <div class="grid-sizer"></div> <!-- no loop this element -->
        </div>
        <div class="more-wrap"><button id="btn-load-2" class="btn-4 load-more"> Load more <i
                    class="fas fa-angle-double-down"></i></button></div>
    </div>
</div><!-- //main -->

</div><!-- //page -->
<script>

    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("a.lk-back").on("click", function (e) {
            e.preventDefault();
            $("select[name='country[]']").val('Singapore');
            $("select[name='month'], select[name='year'], select[name='topic'], select[name='stage']")
                .val('').selectpicker('refresh');
            getSearchResult('clear');
        });

        var country_array = [];
        var month_array = [];
        var year_array = [];
        var topic_array = [];
        var stage_array = [];

        $("select[name='country[]']").on("change", function() {
            country_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='month']").on("change", function() {
            month_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='year']").on("change", function() {
            year_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='topic']").on("change", function() {
            topic_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='stage']").on("change", function() {
            stage_array.push($(this).val());
            getSearchResult();
        });

        function getSearchResult(option_type) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/regulatory-details-search') }}",
                data  : {
                    country : country_array,
                    month : month_array,
                    year : year_array,
                    topic : topic_array,
                    stage : stage_array,
                    option_type : option_type,
                    _token: CSRF_TOKEN,
                },
                cache: false,
                async: false,
                success: function(data) {
                    $("#list-2").html(data);
                }
            });
            country_array = [];
            month_array = [];
            year_array = [];
            topic_array = [];
            stage_array = [];
        }
    });

</script>
@endsection
