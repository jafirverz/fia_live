<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/plugin.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body>
    <div id="toppage" class="page">

        <div class="main-wrap">
            <div class="container">
                <div class="col-md-12" style="background-color: #333;padding: 15px;">
                    <img src="{{ asset('uploads/systemSettings/fia-logo_1560875093.png') }}" width="120px">
                </div>
                <div class="intro-2 ">
                    <h1 class="title-1 text-center space-2"><img
                            src="{{ getFilterCountryImage($regulatory->country_id) }}"
                            alt="{{ getFilterCountry($regulatory->country_id) }}" />
                        {{ getFilterCountry($regulatory->country_id) }}:{{ $regulatory->title }}</h1>
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
                                        style="color: #fb7a10;">{{ $regulatory->date_of_regulation_in_force->format('d M Y') }}</strong>
                                </td>
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
                                    <br />
                                    @endif
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if ($child_regulatory)
                @foreach ($child_regulatory as $key => $value)
                <div class="intro-2">
                    <h4>{{ $value->title }}</h4>
                    <p>{{ getFilterStage($value->stage_id) }} | {{ $value->updated_at->format('d M Y') }}</p>
                    {!! $value->description !!}
                </div>
                @endforeach
                @endif

            </div>

        </div><!-- //main -->

    </div><!-- //page -->
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
</body>

</html>
