@extends('layouts.app')

@section('content')
    <div class="main-wrap">
        @include('inc.banner')
        <div class="container thanks-wrap">
            <?php
            $key = ['{{email}}'];
            $value = [$email];
            $newContents = replaceStrByValue($key, $value, $page->contents);
            ?>
            {!! $newContents!!}
        </div>

    </div><!-- //main -->


@endsection
