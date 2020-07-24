@extends('layouts.app')

@section('content')
@section('facebook_meta')
@if($podcast)
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $podcast->title }}" />
<title>{{ $podcast->title }}</title>
<meta property="og:description" content="{{$podcast->description}}" />
<link rel="canonical" href="{{url('podcast').'?id='.$podcast->id}}" />
<meta property="og:url" content="{{url('podcast').'?id='.$podcast->id}}" />
<meta property="og:image" content="{{ asset($podcast->social_image) }}" />
<meta property="og:site_name" content=".{{request()->getHost()}}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ url('/')}}" />
<meta name="twitter:title" content="{{ $podcast->podcast_title }}" />
<meta name="twitter:description" content="{{$podcast->description}}" />
<meta name="twitter:image" content="{{ asset($podcast->podcast_image) }}" />
<meta name="twitter:domain" content=".{{request()->getHost()}}" />
@endif

@endsection
<div id="toppage" class="page">
    <div class="main-wrap">
    <h1 class="hidden">{{ $podcast->title}}</h1>
        @include('inc.banner')
        <div class="container space-1">
            <div class="share-wrap">
                <span class="txt">Share</span>
                <div class="addthis_inline_share_toolbox_rv7n share"></div>
                <script type="text/javascript"
                    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56396709ddc4b297"></script>
            </div>
            @if($podcast)
            <div class="document">
                <div class="text-center">
                    <img src="{{ asset($podcast->podcast_image) }}" alt="" />
                </div>
                <div class="audio-wrap">
                    <audio id="audio" controls controlslist="nodownload" autoplay="">
                        <source src="{{asset($podcast->audio_file)}}" type="audio/mpeg">
                    </audio>
                </div>
                <h3>{{$podcast->title}}</h3>
                <p class="date">{{date('j F Y',strtotime($podcast->created_at))}} | @if($podcast->topical_id)
                    {!! getTopicsName(json_decode($podcast->topical_id))!!}
                    @endif</p>
                {!!$podcast->description!!}

            </div>
            @endif
            <div class="filter-wrap-2 clearfix">
                <label class="lb">Filter by</label>
                <div class="content">
                    <div class="inner">
                        <div class="row">
                            <form name="filter" method="get" action="{{url('podcast/search')}}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="col-sm-5 bcol">
                                    <select data-live-search="true" id="topical_id" name="topical_id"
                                        class="selectpicker">
                                        <option value="">Sort based on Topics / Categories</option>
                                        @if($topics)
                                        @foreach ($topics as $topic)
                                        <option @if(isset($_GET['topical_id']) && $topic->id==$_GET['topical_id'])
                                            selected @endif value="{{ $topic->id }}">{{ $topic->tag_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4 bcol">
                                    <input type="text" name="keyword" class="form-control" placeholder="keyword"
                                        value="@if(isset($_GET['keyword']) && $_GET['keyword']!='') {{$_GET['keyword']}} @endif" />
                                </div>
                                <div class="col-sm-3 bcol">
                                    @if(isset($_GET['id']) && $_GET['id']!='')
                                    <input type="hidden" name="id" value="{{$_GET['id']}}" />
                                    @endif

                                    <button class="btn-5 btn-block" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if($podcasts->count()>0)
            @foreach($podcasts as $podcast)
            <div class="grid-5 clearfix">
                <figure class="imgwrap">
                    <a href="{{url('podcast').'?id='.$podcast->id}}"><img src="{{ asset($podcast->podcast_image) }}"
                            alt="" /></a>
                </figure>
                <div class="descripts">
                    <h3><a href="{{url('podcast').'?id='.$podcast->id}}">{{$podcast->title}}</a></h3>
                    <p class="type">{{date('j F Y',strtotime($podcast->created_at))}} |
                        @if($podcast->topical_id)
                        {!! getTopicsName(json_decode($podcast->topical_id)) !!}
                        @endif</p>
                    @if(strlen($podcast->description)>330)
                    <p>{!!substr($podcast->description,0,330)!!}...</p>
                    @else
                    <p>{!! $podcast->description !!}</p>
                    @endif
                    <a class="btn-3" href="{{url('podcast').'?id='.$podcast->id}}">Read more</a>
                </div>

            </div>
            @endforeach

            <div class="pager">
                {{$podcasts->links()}}
            </div>
            @else
            <p class="text-center">No result found.</p>
            @endif
        </div>

    </div><!-- //main -->

</div><!-- //page -->
@endsection