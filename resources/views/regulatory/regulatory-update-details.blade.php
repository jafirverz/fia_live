
@extends('layouts.app')

@section('content')
@php
$id = $_GET['id'] ?? '';
@endphp
<div id="toppage" class="page">

    <div class="main-wrap">
        @include('inc.banner')
        <div class="container space-1">
            @if(Auth::check())
            <div class="tb-col action-wrap-1">
                <div class="col">
                    <a class="fas fa-angle-double-left lk-back" href="{{ url('regulatory-updates') }}">Back</a>
                </div>
                <div class="col">
                    <a href="{{ url('regulatory-print', $regulatory->slug) }}" target="_blank"
                        class="btn-4 export_link">EXPORT <i class="fas fa-file-export"></i></a>
                </div>
            </div>

            <div class="intro-2 ">
                <h1 class="title-1 text-center space-2">@if(file_exists(str_replace(url('/').'/', '', getFilterCountryImage($regulatory->country_id))))<img src="{{ getFilterCountryImage($regulatory->country_id) }}"
                        alt="{{ getFilterCountry($regulatory->country_id) }}" />@endif
                    {{ $regulatory->title }}</h1>
                <table>
                    <tbody>
                        <tr>
                            <td><strong>Agency Responsible:</strong></td>
                            <td>{{ $regulatory->agency_responsible }}</td>
                        </tr>
                        <!--<tr>
                                <td><strong>Stage:</strong></td>
                                <td>Implemented with First Amendment</td>
                            </tr>-->
                        <tr>
                            <td><strong style="color: #fb7a10;">Date of Regulation in Force:</strong></td>
                            <td><strong
                                    style="color: #fb7a10;">@if($regulatory->date_of_regulation_in_force) {{ $regulatory->date_of_regulation_in_force->format('d M Y') }} @endif</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Topic(s):</strong></td>
                            <td>
                                @php
                                $db_topics = json_decode($regulatory->topic_id);
                                $topics = getFilterTopic();
                                @endphp
                                @if ($topics && $db_topics)
                                @foreach ($topics as $value)
                                @if(in_array($value->id, $db_topics))
                                {{ $value->tag_name }}
                                @if (!$loop->first)
                                <br />
                                @endif
                                @endif
                                @endforeach
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mbox-wrap" data-num="5">
                @if ($child_regulatory)
                @foreach ($child_regulatory as $key => $value)
                <div class="box-3 noheight mbox @if($loop->first) open @endif" data-id="{{ $value->id }}">
                    <a class="head-box head-tb" data-height="0" href="#update-{{ ($key+1) }}">
                        <span class="tb-col break-640">
                            <span class="col">{{ $value->title }}</span>
                            <span class="col w-1">{{ getFilterStage($value->stage_id) }}</span>
                            <span class="col w-2">@if($value->regulatory_date) {{ date('d M Y', strtotime($value->regulatory_date)) }} @else - @endif</span>
                        </span>
                    </a>
                    <div class="content-box" id="update-{{ ($key+1) }}">
                        <div class="document">
                            {!! $value->description !!}
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <div class="more-wrap"><button class="btn-4 mbox-load"> Load more <i
                            class="fas fa-angle-double-down"></i></button></div>
            </div>
            @else
                <div class="space-1">
                    @include('admin.inc.message')
                    <form class="form-wrap-1 form-type form-ani" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <h1 class="title-1 text-center">Sign in to your account</h1>
                        <div class="inrow">
                            <span><input type="text" name="email" class="form-control" /></span>
                            <label>Email Address</label>
                        </div>
                        <div class="inrow">
                            <span><input type="password" name="password" class="form-control" /></span>
                            <label>Password</label>
                            <input type="hidden" name="redirect" value="{{ url()->full() }}">
                        </div>
                        <div class="form-group">
                            <div class="google-recaptcha">
                                <div class="g-recaptcha" data-callback="onSubmit"
                                     data-sitekey="{{env('CAPTCHA_SITE_KEY')}}" data-size="invisible"></div>
                                <input type="hidden" title="Please verify this" class="required" name="keycode"
                                       id="keycode">
                                <div id="cap-response" style="display:none; color:#F00;"></div>

                            </div>
                        </div>
                        <button type="submit" class="btn-2">Sign in</button>
                        <div class="links">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            @endif
        </div>

    </div><!-- //main -->

</div><!-- //page -->
 @include('inc.feedback-form')
<script>
    var slug = "{{ url('regulatory-print', $regulatory->slug) }}";

    var array_list = [];

    var id = '{{ $id }}';

    if(id)
    {
        array_list.push(id);
        $('div.box-3').removeClass("open");
        $('div.box-3[data-id="'+id+'"]').addClass("open");
        $("a.export_link").attr("href", slug + '?id=' + array_list.join());
    }
    else
    {
        hasClassOpen();
    }
    $("div.box-3").on("click", function () {
        if ($(this).hasClass('open')) {
            array_list.push($(this).attr('data-id'));
        } else {
            array_list.pop($(this).attr('data-id'));
        }
        $("a.export_link").attr("href", slug + '?id=' + array_list.reverse().join());
    });

    function hasClassOpen() {
        array_list.push($("div.box-3.open").attr('data-id'));
        $("a.export_link").attr("href", slug + '?id=' + array_list.join());
    }

</script>
@endsection

