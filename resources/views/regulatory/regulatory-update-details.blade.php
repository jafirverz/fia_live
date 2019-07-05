@extends('layouts.app')

@section('content')
<div id="toppage" class="page">

    <div class="main-wrap">
        @include('inc.breadcrumb');
        <div class="container space-1">
            <div class="tb-col action-wrap-1">
                <div class="col">
                    <a class="fas fa-angle-double-left lk-back" href="{{ url('regulatory-updates') }}">Back</a>
                </div>
                <div class="col">
                    <a href="#" class="btn-4">EXPORT <i class="fas fa-file-export"></i></a>
                </div>
            </div>
            <div class="intro-2">
                <h1 class="title-1 text-center space-2"><img src="{{ getFilterCountryImage($regulatory->country_id) }}" alt="{{ getFilterCountry($regulatory->country_id) }}" /> {{ getFilterCountry($regulatory->country_id) }}:{{ $regulatory->title }}</h1>
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
                            <td><strong style="color: #fb7a10;">{{ $regulatory->date_of_regulation_in_force->format('d M Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Topic(s):</strong></td>
                            <td>
                                @php
                                    $topics = getFilterTopic();
                                @endphp
                                @if ($topics)
                                    @foreach ($topics as $value)
                                        {{ $value->tag_name }}
                                        @if (!$loop->first)
                                            <br/>
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
                <div class="box-3 noheight mbox @if($loop->first) open @endif">
                    <a class="head-box head-tb" data-height="0" href="#update-{{ ($key+1) }}">
                        <span class="tb-col break-640">
                            <span class="col">{{ $value->title }}</span>
                            <span class="col w-1">{{ getFilterStage($value->stage_id) }}</span>
                            <span class="col w-2">{{ $value->updated_at->format('d M Y') }}</span>
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

        </div>

    </div><!-- //main -->

</div><!-- //page -->
@endsection
