@extends('layouts.app')

@section('content')
    <div class="main-wrap">
        @include('inc.banner')
        <div class="container space-1">
            <h1 class="title-1 text-center">Search Results</h1>

            <div class="intro-1 space-3">
                @if(count($informations)<=0 && count($regulatories)<=0 && count($resources)<=0 &&count($others)<=0)
                    <p>No result found for <b>{{$_REQUEST['search_content']}}</b>.</p>
                @else(isset($_REQUEST['search_content']))
                    <p>Your search for <b>{{$_REQUEST['search_content']}}</b> has brought back these results</p>
                @endif
            </div>
            @if(count($informations)>0)
                <div class="box-5 clearfix mlist-wrap">
                    <figure>
                        <div class="image"><img src="{{asset('images/tempt/ico-1.png')}}" alt=""/></div>
                    </figure>
                    <div class="content">
                        <h2>Country information</h2>
                        <ul class="mlist" data-num="{{ setting()->pagination_limit }}">
                            @foreach($informations as $info)
                                @php
                                $keyword=strip_tags($_REQUEST['search_content']);
                                $link=str_replace(" ","+",$info['link']);
                                @endphp
                                <li class="mlist-line"><a href="{{ $link.'&id='.$info['id']}}">{{$info['country']}}
                                        : {!!  preg_replace("/($keyword)/i","<b>$1</b>",$info['content']); !!}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @if(count($informations)>setting()->pagination_limit)
                        <a class="see-all" href="#">Load more</a>
                    @endif
                </div>
            @endif
            @if(count($regulatories)>0)
                <div class="box-5 clearfix mlist-wrap">
                    <figure>
                        <div class="image"><img src="{{asset('images/tempt/ico-2.png')}}" alt=""/></div>
                    </figure>
                    <div class="content">
                        <h2>Regulatory updates</h2>
                        <ul class="mlist" data-num="{{ setting()->pagination_limit }}">
                            @foreach($regulatories as $info)
                                @php
                                $keyword=strip_tags($_REQUEST['search_content']);
                                @endphp
                                @if($info['parent_id']==NULL)
                                <li class="mlist-line"><a href="{{ $info['link']}}">{!!  $info['title'] !!}</a></li>
                                @else
                                @php 
                                $parent_regulatory_title=getParentRegulatory($info['parent_id']);
                                @endphp
                                <li class="mlist-line">
                                    <ul>
                                     <li class="mlist-line"><a href="{{ $info['link']}}">{!!  $info['title'] !!}</a></li>
                                    </ul>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @if(count($regulatories)>setting()->pagination_limit)
                        <a class="see-all" href="#">Load more</a>
                    @endif
                </div>
            @endif
            @if(count($resources)>0)
                <div class="box-5 clearfix mlist-wrap">
                    <figure>
                        <div class="image"><img src="{{asset('images/tempt/ico-3.png')}}" alt=""/></div>
                    </figure>
                    <div class="content">
                        <h2>resources</h2>
                        <ul class="mlist" data-num="{{ setting()->pagination_limit }}">
                            @foreach($resources as $info)
                                @php
                                $keyword=strip_tags($_REQUEST['search_content']);
                                $report_id = isset($info['id']) ? '?id=report-'.$info['id'] : '';
                                @endphp
                                <li class="mlist-line"><a
                                            href="{{ $info['link'].$report_id }}">{!!  preg_replace("/($keyword)/i","<b>$1</b>",$info['content']); !!}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if(count($resources)>setting()->pagination_limit)
                        <a class="see-all" href="#">Load more</a>
                    @endif
                </div>
            @endif
            @if(count($others)>0)
                <div class="box-5 clearfix mlist-wrap">
                    <figure>
                        <div class="image"><img src="{{asset('images/tempt/ico-4.png')}}" alt=""/></div>
                    </figure>
                    <div class="content">
                        <h2>others</h2>
                        <ul class="mlist" data-num="{{ setting()->pagination_limit }}">
                            @foreach($others as $info)
                                @php
                                $keyword=strip_tags($_REQUEST['search_content']);
                                @endphp
                                <li class="mlist-line"><a
                                            href="{{ $info['link']}}">{!!  preg_replace("/($keyword)/i","<b>$1</b>",$info['content']); !!}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if(count($others)>setting()->pagination_limit)
                        <a class="see-all" href="#">Load more</a>
                    @endif
                </div>
            @endif
        </div>

    </div><!-- //main -->

    @include('inc.feedback-form')
@endsection
