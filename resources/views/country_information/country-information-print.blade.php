@php
$contents = getCountryInformationBasedOnDetails($_GET['country'], $_GET['category']);
$id = $_GET['id'];
@endphp
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
                    <div class="tb-col title-wrap-1 break-640">
                        <div class="col">
                            <h1 class="title-1">{{ $_GET['country'] ?? '' }}</h1>
                            <h2 class="title-2">{{ $_GET['category'] ?? '' }}</h2>
                        </div>
                        <div class="col">
                            <a href="#" class=""> &nbsp; </a>
                        </div>
                    </div>

                </div>
                @if($contents)
                @foreach ($contents as $key => $content)
                <div class="intro-2 box-content" data-id="{{ $content->id }}">
                    <h4>{{ $content->information_title }}</h4>
                    <p>{!! $content->information_content !!}</p>
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
        $(document).ready(function () {
            $("div.box-content").addClass("hide");
            var id = '{{ $id }}';
            var array_id = id.split(',');
            if(array_id)
            {
                jQuery.each(array_id, function (i, val) {
                    $("[data-id='" + val + "']").removeClass("hide");
                });
            }
            else
            {
                $("[data-id='" + id + "']").removeClass("hide");
            }
            //window.print();
        });

    </script>
</body>

</html>
