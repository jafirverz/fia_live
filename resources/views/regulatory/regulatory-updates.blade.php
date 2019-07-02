@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
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
                            <option data-content='<img src="images/tempt/flag-afghanistan.jpg" alt="china" /> {{ $country->tag_name }}' @if($country->tag_name=='Singapore') selected @endif> {{ $country->tag_name }}</option>
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
                                <option value="{{ $topic->tag_name }}">{{ $topic->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker" name="stage">
                                <option value="">-- Stage --</option>
                                @foreach (getFilterStage() as $stage)
                                <option value="{{ $stage->tag_name }}">{{ $stage->tag_name }}</option>
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
                    @if (getRegulatoriesHighlight())
                    @foreach (getRegulatoriesHighlight() as $value)
                    <div class="item @if($loop->first) w-1 @endif">
                        <div class="box-4">
                            <figure><img src="images/tempt/flag-korea.jpg" alt="korean flag" /></figure>
                            <div class="content">
                                <h3 class="title">{{ $value->title }}</h3>
                                <p class="date"><span class="country">{{ getFilterCountry($value->country_id) }}</span> |{{ $value->created_at->format('M d, Y') }}</p>
                                {!! Illuminate\Support\Str::limit($value->description, 400) !!}
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail" href="{{ url('regulatory-details', $value->slug) }}">View detail</a>
                        </div>
                    </div>
                    @endforeach
                    @endif

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
                        <figure><img src="images/tempt/flag-korea.jpg" alt="thailand flag" /></figure>
                        <div class="content">
                            <h3 class="title">{{ $value->title }}</h3>
                            <p class="date"><span class="country">{{ getFilterCountry($value->country_id) }}</span> | {{ $value->created_at->format('M d, Y') }}</p>
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
        $("a.lk-back").on("click", function (e) {
            e.preventDefault();
            $("select[name='country[]']").val('Singapore');
            $("select[name='month'], select[name='year'], select[name='topic'], select[name='stage']")
                .val('').selectpicker('refresh');
        });
    });

</script>
@endsection
