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
        
        
        <div class="container space-1 search-results">
        <div id="search-list" class="masony grid-2" data-num="8" data-load="#btn-load">
         @if($regulatories)
                    @foreach($regulatories as $regulatory)
						<div class="item">
							<div class="box-4">
								<figure><img src="{{getFilterCountryImage($regulatory->country_id)}}" alt="{{getFilterCountry($regulatory->country_id)}} flag" /></figure>
								<div class="content">
									<h3 class="title">{{$regulatory->title}}</h3>
									<p class="date"><span class="country">{{getFilterCountry($regulatory->country_id)}}</span>  |  {{ $regulatory->created_at->format('M d, Y') }}</p>
									<p>{!! substr(strip_tags($regulatory->description),0,120) !!}</p>
									<p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
								</div>
								<a class="detail" href="{{url('regulatory-details',$regulatory->slug)}}">View detail</a>
							</div>						
						</div>
					@endforeach 
                    @endif 
                    <!-- no loop this element --> <div class="grid-sizer"></div> <!-- no loop this element -->	 
                    </div>
            
        </div>
       
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
