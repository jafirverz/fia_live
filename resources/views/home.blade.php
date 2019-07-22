@extends('layouts.app')
@section('content')
    <div class="main-wrap">
        <h1 class="hidden">Food Industry Asia</h1>
        @include('inc.banner');
        <div class="map-wrap">
            <div class="map-pins">
                <img src="{{asset('images/map.jpg')}}" alt="map" />
                <!--<a class="pin p-mon" href="#mongolia"><span class="flag"><img src="images/tempt/flag-mongolia.jpg" alt="MONGOLIA flag" /></span><span class="text">MONGOLIA</span></a>-->
               @if(checkCountryExist('China')==1)
                <a class="pin p-chi" href="#china"><span class="flag"><img src="images/tempt/flag-china.jpg"
                            alt="China flag" /></span><span class="text">China</span></a>
               @endif
               @if(checkCountryExist('Japan')==1)
                <a class="pin p-jap" href="#japan"><span class="flag"><img src="images/tempt/flag-japan.jpg"
                            alt="Japan flag" /></span><span class="text">Japan</span></a>
               @endif
                <!--<a class="pin p-nep" href="#nepal"><span class="flag"><img src="images/tempt/flag-nepal.jpg" alt="Nepal flag" /></span><span class="text">Nepal</span></a>-->
               @if(checkCountryExist('Korea')==1)
                <a class="pin p-kor" href="#korea"><span class="flag"><img src="images/tempt/flag-korea.jpg"
                            alt="Korea flag" /></span><span class="text">Korea</span></a>
               @endif
                <!--<a class="pin p-bhu" href="#bhutan"><span class="flag"><img src="images/tempt/flag-bhutan.jpg" alt="Bhutan flag" /></span><span class="text">Bhutan</span></a>-->
               @if(checkCountryExist('Chinese Taipei')==1)
                <a class="pin p-tai" href="#chinese_taipei"><span class="flag"><img src="images/tempt/flag-taipei.jpg"
                            alt="Taipei flag" /></span><span class="text">Chinese Taipei</span></a>
               @endif
                <!--<a class="pin p-afg" href="#afghanistan"><span class="flag"><img src="images/tempt/flag-afghanistan.jpg" alt="Afghanistan flag" /></span><span class="text">Afghanistan</span></a>-->
               @if(checkCountryExist('Hongkong SAR')==1)
                <a class="pin p-hon" href="#hongkong_sar"><span class="flag"><img src="images/tempt/flag-hongkong.jpg"
                            alt="Hongkong flag" /></span><span class="text">Hongkong SAR</span></a>
               @endif
                <!--<a class="pin p-ban" href="#bangladesh"><span class="flag"><img src="images/tempt/flag-bangladesh.jpg" alt="Bangladesh flag" /></span><span class="text">Bangladesh</span></a>-->
                <!--<a class="pin p-pak" href="#pakistan"><span class="flag"><img src="images/tempt/flag-pakistan.jpg" alt="Pakistan flag" /></span><span class="text">Pakistan</span></a>-->
               @if(checkCountryExist('Macau SAR')==1)
                <a class="pin p-mac" href="#macau_sar"><span class="flag"><img src="images/tempt/flag-macau.jpg"
                            alt="Macau SAR flag" /></span><span class="text">Macau SAR</span></a>
               @endif
               @if(checkCountryExist('Myanmar')==1)
                <a class="pin p-mya" href="#myanmar"><span class="flag"><img src="images/tempt/flag-myanmar.jpg"
                            alt="Myanmar flag" /></span><span class="text">Myanmar</span></a>
               @endif
               @if(checkCountryExist('Laos')==1)
                <a class="pin p-lao" href="#laos"><span class="flag"><img src="images/tempt/flag-laos.jpg"
                            alt="Laos flag" /></span><span class="text">Laos</span></a>
               @endif
               @if(checkCountryExist('India')==1)
                <a class="pin p-ind" href="#india"><span class="flag"><img src="images/tempt/flag-india.jpg"
                            alt="India flag" /></span><span class="text">India</span></a>
               @endif
               @if(checkCountryExist('Thailand')==1)
                <a class="pin p-tha" href="#thailand"><span class="flag"><img src="images/tempt/flag-thailand.jpg"
                            alt="Thailand flag" /></span><span class="text">Thailand</span></a>
               @endif
               @if(checkCountryExist('Vietnam')==1)
                <a class="pin p-vie" href="#vietnam"><span class="flag"><img src="images/tempt/flag-vietnam.jpg"
                            alt="Vietnam flag" /></span><span class="text">Vietnam</span></a>
               @endif
               @if(checkCountryExist('Philippines')==1)
                <a class="pin p-phi" href="#philippines"><span class="flag"><img src="images/tempt/flag-philippines.jpg"
                            alt="Philippines flag" /></span><span class="text">Philippines</span></a>
               @endif
                @if(checkCountryExist('Sri Lanka')==1)
                <a class="pin p-sri" href="#sri_lanka"><span class="flag"><img src="images/tempt/flag-sri-lanka.jpg"
                            alt="Sri lanka flag" /></span><span class="text">Sri lanka</span></a>
                @endif
                 @if(checkCountryExist('Cambodia')==1)
                <a class="pin p-cam" href="#cambodia"><span class="flag"><img src="images/tempt/flag-combodia.jpg"
                            alt="cambodia flag" /></span><span class="text">cambodia</span></a>
                @endif
                 @if(checkCountryExist('Malaysia')==1)
                <a class="pin p-mal" href="#malaysia"><span class="flag"><img src="images/tempt/flag-malaysia.jpg"
                            alt="Malaysia flag" /></span><span class="text">Malaysia</span></a>
                @endif
                @if(checkCountryExist('Brunei')==1)
                <a class="pin p-bru" href="#brunei"><span class="flag"><img src="images/tempt/flag-brunei.jpg"
                            alt="brunei flag" /></span><span class="text">brunei</span></a>

                @endif            
                @if(checkCountryExist('Singapore')==1)            
                <a class="pin p-sin open" href="#singapore"><span class="flag"><img src="images/tempt/flag-singapore.jpg"

                            alt="singapore flag" /></span><span class="text">singapore</span></a>
                @endif
                @if(checkCountryExist('Indonesia')==1)
                <a class="pin p-indo" href="#indonesia"><span class="flag"><img src="images/tempt/flag-indonesia.jpg"
                            alt="Indonesia flag" /></span><span class="text">Indonesia</span></a>
                @endif
                <!--<a class="pin p-tim" href="#timor"><span class="flag"><img src="images/tempt/flag-timor-leste.jpg" alt="TIMOR-LESTE flag" /></span><span class="text">TIMOR-LESTE</span></a>-->
               @if(checkCountryExist('Australia')==1)
                <a class="pin p-aus" href="#australia"><span class="flag"><img src="images/tempt/flag-australia.jpg"
                            alt="Australia flag" /></span><span class="text">Australia</span></a>
               @endif
               @if(checkCountryExist('New Zealand')==1)
                <a class="pin p-new" href="#new_zealand"><span class="flag"><img src="images/tempt/flag-new-zealand.jpg"
                            alt="NEW ZEALAND flag" /></span><span class="text">NEW ZEALAND</span></a>
                 @endif
            </div>
           <div id="map_country_detail">

           @php
            $country = isset($_GET['country']) ? $_GET['country'] : '';
            $country_id=getCountryId($country);
            $category=get_categry_by_country($country_id);
           @endphp
            <div id="singapore" class="pin-pp openpp"><div class="tb-col">
            <div class="col">
            <div class="content">
            <a href="#new" class="fas fa-times">Close</a>
            <h2>singapore</h2>
            <a class="fas fa-angle-double-right link" href="{{url('search-results-regulatory?country=singapore')}}"><span class="ico"><img src="{{url(asset('images/tempt/ico-5.png'))}}" alt=""></span> Regulatory Updates</a>
            @if($category=='#')
            <a style="background:#CCC;" class="fas fa-angle-double-right link"><span class="ico"><img src="{{url(asset('tempt/ico-6.png'))}}" alt=""></span> Country Information</a>
            @else
            <a class="fas fa-angle-double-right link" href="{{url('country-information-details?country=singapore&amp;category='.$category)}}"><span class="ico"><img src="{{url(asset('images/tempt/ico-6.png'))}}" alt=""></span> Country Information</a>
            @endif
            </div>
            </div>
            </div>
            </div>

            </div>

        </div>
        <div class="intro-home-1 container-fluid">
            <div class="row">
                <div class="col-sm-5">
                    <div class="intro spleft">
                        {!! $page->other_contents1 !!}
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="grid-2 slick-1">
                    @if(getRegulatoriesHighlight())
        @php
        $regulatory_highlight = getRegulatoriesHighlight();

        $other_highlight_array = [
        $regulatory_highlight->main_highlight,
        $regulatory_highlight->other_highlight1,
        $regulatory_highlight->other_highlight2,
        $regulatory_highlight->other_highlight3,
        $regulatory_highlight->other_highlight4,
        $regulatory_highlight->other_highlight5,
        ];
        $other_highlight_array=array_filter($other_highlight_array);


       $i=0;
        foreach($other_highlight_array as $key=>$value)
        {
	   $i++;
        $regulatory = getRegulatoryById($value);
       if( $regulatory)  {
       if($i<=3)
       {
        @endphp


                        <div class="item">
                            <div class="box-4">
                                <figure><img src="{{getFilterCountryImage($regulatory->country_id)}}" alt="{{getFilterCountry($regulatory->country_id)}} flag" /></figure>
                                <div class="content">
                                    <h3 class="title">{{$regulatory->title}}</h3>
                                    <p class="date"><span class="country">{{getFilterCountry($regulatory->country_id)}}</span> | {{ $regulatory->created_at->format('M d, Y') }}</p>
                                    <p>{!! Illuminate\Support\Str::limit($regulatory->description, 120) !!}</p>
                                    <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                                </div>
                                <a class="detail" href="{{url('regulatory-details',$regulatory->slug)}}">View detail</a>
                            </div>
                        </div>
                   @php }}} @endphp
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-home-2 tb-col break-720">
         @if(!Auth::check())
          @php
          $video='<video controls=""><source src="'.$page->video1.'" type="video/mp4"></video>';
          echo $other_contents2=str_replace("{{VIDEO_HOME}}",$video,$page->other_contents2);

          @endphp
         @else
          @php
          $video='<video controls=""><source src="'.$page->video2.'" type="video/mp4"></video>';
          echo $other_contents2=str_replace("{{VIDEO_HOME}}",$video,$page->other_contents2);

          @endphp
         @endif
        </div>
        <div class="intro-home-3">
    <div class="container">

         @if(!Auth::check())
          @php
           $REGULATORY_LOGIN_LINK='<a href="'.url('login').'?page=regulatory-updates&type=login"></a>';
           $COUNTRY_LOGIN_LINK='<a href="'.url('login').'?page=country-information&type=login"></a>';
           $RESOURCE_LOGIN_LINK='<a href="'.url('login').'?page=topical-reports&type=login"></a>';
           $get_access='<p class="more">Get access <span class="fas fa-angle-double-right"></span></p>';
           $other_contents3=$page->other_contents3;
           $other_contents3=str_replace("{{GET_ACCESS}}",$get_access,$other_contents3);
           $other_contents3=str_replace("{{REGULATORY_LINK}}",$REGULATORY_LOGIN_LINK,$other_contents3);
           $other_contents3=str_replace("{{COUNTRY_LINK}}",$COUNTRY_LOGIN_LINK,$other_contents3);
           $other_contents3=str_replace("{{RESOURCE_LINK}}",$RESOURCE_LOGIN_LINK,$other_contents3);
           echo $other_contents3;

          @endphp
         @else
          @php
            $REGULATORY_LINK='<a href="regulatory-updates"></a>';
            $COUNTRY_LINK='<a href="country-information"></a>';
            $RESOURCE_LINK='<a href="topical-reports"></a>';
            $get_access='<p class="more">Enter <span class="fas fa-angle-double-right"></span></p>';
           $other_contents3=$page->other_contents3;
           $other_contents3=str_replace("{{GET_ACCESS}}",$get_access,$other_contents3);
           $other_contents3=str_replace("{{REGULATORY_LINK}}",$REGULATORY_LINK,$other_contents3);
           $other_contents3=str_replace("{{COUNTRY_LINK}}",$COUNTRY_LINK,$other_contents3);
           $other_contents3=str_replace("{{RESOURCE_LINK}}",$RESOURCE_LINK,$other_contents3);
           echo $other_contents3;

          @endphp
         @endif
        @if(!Auth::check())
        <div class="intro">
<h3>Get access to exclusive tools, regional insights and resources with FIA exclusive membership.</h3>
<a class="btn-2" href="{{ url('register')}}">REGISTER NOW!</a></div>
        @endif
    </div>
</div>
        @include('inc.subscription-footer')

    </div>
<script type="text/javascript">

    $(document).ready(function() {
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		$(".map-pins a").on("click", function() {
			var country_name= $(this).text();
			var country= $(this).text();
		   country=country.toLowerCase();
		   country=country.replace(" ", "_");

		   var content;
		   content+='<div id="'+country+'" class="pin-pp">';
           content+='<div class="tb-col">';
           content+='<div class="col">';
           content+='<div class="content">';
           content+='<a href="#new" class="fas fa-times">Close</a>';
           content+='<h2>'+$(this).text()+'</h2>';
           content+='<a class="fas fa-angle-double-right link" href="search-results-regulatory?country='+$(this).text()+'"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>';

			$.ajax({
                type: 'GET',
                url: "{{ url('/country-information-category') }}",
                data: {
                    country:$(this).text(),
                    _token: CSRF_TOKEN,
                },
                cache: false,
                async: false,
                success: function (data) {
		   if(data=='#')
           content+='<a class="fas fa-angle-double-right link" style="background:#CCC;"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>';
           else
           content+='<a class="fas fa-angle-double-right link" href="country-information-details?country='+country_name+'&category='+data+'"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>';
			       // $(".search-results").html(data);
                }
            });

			content+='</div></div></div></div>';
           //alert(content);
		   $( "#map_country_detail" ).html(content);

		   $('.map-wrap .fa-times').each(function(){
		    $(this).click(function(e){
	        e.preventDefault();
			 $('.map-wrap .pin').removeClass('open');
			 $('.map-wrap .pin-pp').removeClass('openpp');
		});
	});


        });


    });
 </script>
<!-- //main -->
<!-- //page -->
@endsection
