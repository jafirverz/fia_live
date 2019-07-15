@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        @include('inc.banner');
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
                                data-content='<img src="{{ $country->country_image ?? '#' }}" alt="{{ $country->tag_name }}" /> {{ $country->tag_name }}'
                                value="{{ $country->id }}"> {{ $country->tag_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker" name="month">
                                <option value="">-- Month --</option>
                                @foreach (getFilterMonth() as $month)
                                <option value="{{ $month->tag_name }}" @if($month->tag_name) @if($month->tag_name==date('F')) selected @endif @endif>{{ $month->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker" name="year">
                                <option value="">-- Year --</option>
                                @foreach (getFilterYear() as $year)
                                <option value="{{ $year->tag_name }}" @if($year->tag_name) @if($year->tag_name==date('Y')) selected @endif @endif>{{ $year->tag_name }}</option>
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
                            <figure><img src="{{ getFilterCountryImage($regulatory_main_highlight->country_id) }}"
                                    alt="{{ getFilterCountry($regulatory_main_highlight->country_id) }}" /></figure>
                            <div class="content">
                                <div class="text-1">
                                    <h3 class="title">{{ $regulatory_main_highlight->title }}</h3>
                                    <p class="date"><span
                                            class="country">{{ getFilterCountry($regulatory_main_highlight->country_id) }}</span>
                                        | {{ $regulatory_main_highlight->created_at->format('d m Y') }}</p>
                                    {!! Illuminate\Support\Str::limit($regulatory_main_highlight->description, 800) !!}
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
                                    <figure><img
                                            src="{{ getFilterCountryImage($regulatory_other_highlight->country_id) }}"
                                            alt="{{ getFilterCountry($regulatory_other_highlight->country_id) }}" />
                                    </figure>
                                    <div class="content">
                                        <div class="ecol">
                                            <h3 class="title">{{ $regulatory_other_highlight->title }}</h3>
                                            <p class="date"><span
                                                    class="country">{{ getFilterCountry($regulatory_other_highlight->country_id) }}</span>
                                                | {{ $regulatory_other_highlight->created_at->format('d m Y') }}</p>
                                            {!! Illuminate\Support\Str::limit($regulatory_other_highlight->description,
                                            300) !!}
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

                                    <figure><img src="{{ getFilterCountryImage($regulatory_other_highlight->country_id) }}"
                                            alt="{{ getFilterCountry($regulatory_other_highlight->country_id) }}" />
                                    </figure>
                                    <div class="content">
                                        <div class="ecol">
                                            <h3 class="title">{{ $regulatory_other_highlight->title }}</h3>
                                            <p class="date"><span
                                                    class="country">{{ getFilterCountry($regulatory_other_highlight->country_id) }}</span>
                                                | {{ $regulatory_other_highlight->created_at->format('d m Y') }}</p>
                                            {!! Illuminate\Support\Str::limit($regulatory_other_highlight->description, 200)
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
            <div class="grid-2 eheight clearfix mbox-wrap" data-num="{{ setting()->pagination_limit ?? 8 }}">
                @php
                $regulatory = getRegulatories();
                @endphp
                @if($regulatory)
                @foreach ($regulatory as $value)
                <div class="item mbox">
                    <div class="box-4">
                        <figure><img src="{{ getFilterCountryImage($value->country_id) }}" alt="thailand flag" /></figure>
                        <div class="content">
                            <div class="ecol">
                                <h3 class="title">{{ $value->title }}</h3>
                                <p class="date"><span class="country">{{ getFilterCountry($value->country_id) }}</span> |
                                    {{ $value->created_at->format('M d, Y') }}</p>
                                {!! Illuminate\Support\Str::limit($value->description, 300) !!}
                            </div>
                        </div>
                        <a class="detail" href="{{ url('regulatory-details', $value->slug) }}">View detail</a>
                    </div>
                </div>
                @endforeach
                @endif
                <div class="more-wrap"><button class="btn-4 mbox-load"> Load more <i
                            class="fas fa-angle-double-down"></i></button></div>
            </div>
        </div>
        @endif
    </div><!-- //main -->

</div><!-- //page -->
<script>
    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("a.lk-back").on("click", function (e) {
            e.preventDefault();
            window.location.reload();
        });

        var country_array = [];
        var month_array = [];
        var year_array = [];
        var topic_array = [];
        var stage_array = [];

        $("select[name='country[]']").on("change", function () {
            country_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='month']").on("change", function () {
            month_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='year']").on("change", function () {
            year_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='topic']").on("change", function () {
            topic_array.push($(this).val());
            getSearchResult();
        });

        $("select[name='stage']").on("change", function () {
            stage_array.push($(this).val());
            getSearchResult();
        });

        function getSearchResult(option_type) {
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
