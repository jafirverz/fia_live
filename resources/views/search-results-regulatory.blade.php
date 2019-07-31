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
                    @if($_GET['country'])
                        @php $countryID=getCountryId($_GET['country']);@endphp
                        @else
                        @php $countryID="";@endphp
                        @endif
                        <select class="selectpicker" data-actions-box="true" name="country[]" multiple>
                                <option data-content='<strong>COUNTRY</strong>'>COUNTRY</option>
                            <!--<option data-content='<img src="images/tempt/flag-afghanistan.jpg" alt="china" /> Afghanistan'> Afghanistan</option>-->
                            @foreach (getFilterCountry() as $country)
                            <option  @if($countryID==$country->id) selected="selected" @endif
                                data-content='<img src="{{ $country->country_image ?? '#' }}" alt="{{ $country->tag_name }}" /> {{ $country->tag_name }}'
                                value="{{ $country->id }}"> {{ $country->tag_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker" name="month">
                                <option value="">-- Month --</option>
                                @foreach (getFilterMonth() as $key => $month)
                                <option value="{{ $key+1 }}">{{ $month->tag_name }}</option>
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
        
        
        <div class="container space-1 search-results">
            <h1 class="title-1 text-center">Search Results</h1>
            <?php $total_regulatories;?>
            @if($regulatories)
            <input type="hidden" name="min_load" value="{{ setting()->pagination_limit ?? 8 }}">
            <div class="grid-2 eheight clearfix mbox-wrap" data-num="{{ setting()->pagination_limit ?? 8 }}">
                 @foreach($regulatories as $regulatory)
						<div class="item mbox">
                    <div class="box-4">
                        <figure><img src="@if($regulatory->country_id) {{ getFilterCountryImage($regulatory->country_id) }} @endif" alt="@if($regulatory->country_id) {{ getFilterCountry($regulatory->country_id) }} @endif flag" /></figure>
                        <div class="content">
                            <div class="ecol">
                                <h3 class="title">{{ $regulatory->title }}</h3>
                                <p class="date"><span class="country">@if($regulatory->country_id) {{ getFilterCountry($regulatory->country_id) }} @endif</span> |
                                    @if($regulatory->regulatory_date) {{ date('M d, Y', strtotime($regulatory->regulatory_date)) }} @endif</p>
                                    {!! Illuminate\Support\Str::limit(strip_tags(getRegulatoryDescription($regulatory->id)), 250) !!}
                            </div>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="@if($regulatory->slug) {{ url('regulatory-details', $regulatory->slug) . '?id=' . $regulatory->id }} @else javascript:void(0) @endif">View detail</a>
                    </div>
                </div>
					@endforeach
                <div class="more-wrap"><button class="btn-4 mbox-load"> Load more <i class="fas fa-angle-double-down"></i></button></div>
            </div>

                @endif

        </div>
       
    </div><!-- //main -->

</div><!-- //page -->
<script>
    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("a.lk-back").on("click", function () {
            var d = new Date();
            $("select[name='country[]']").val('');
            $("select[name='month']").val(d.getMonth()+1);
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
       
    });

</script>
@endsection
