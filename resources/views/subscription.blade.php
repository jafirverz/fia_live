@extends('layouts.app')

@section('content')
    <div class="main-wrap">
        @include('inc.banner')
        <div class="container @if($page->slug!='thank-you') space-1 @else thanks-wrap @endif">

            {{--{!! $page->contents!!}--}}
            <?php if(!empty($response['code'])) { ?>
            <div class="alert alert-<?php echo $response['code']; ?>">
                <?php echo $response['message']; ?>
            </div>
            <?php } ?>
            <form action="{{ url('paypal/ec-checkout') }}" method="GET" class="form-wrap-1 form-type form-ani">
                <h1 class="title-1 text-center">Subscription</h1>
                <div class="inrow">
                    <span><input type="text" class="form-control @if ($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" /></span>
                    <label>Email Address</label>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>&emsp;{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="checkbox"><input type="checkbox" value="recurring" id="recurring" name="mode"
                                             @if(is_null(old('mode')) || old('mode')=='recurring')checked="checked" @endif><label for="recurring" class="recurring">Recurring
                        Subscription</label></div>
                <div class="checkbox"><input type="checkbox" value="non-recurring" id="non-recurring"
                                             @if(old('mode')=='non-recurring')checked="checked" @endif
                                             name="mode"><label for="non-recurring" class="non-recurring">Non
                        -
                        Recurring
                        Subscription</label><br/>
                    @if ($errors->has('mode'))
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $errors->first('mode') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="captcha">
                    <div class="google-recaptcha">
                        <div class="g-recaptcha" data-callback="onSubmit"
                             data-sitekey="{{env('CAPTCHA_SITE_KEY')}}" data-size="invisible"></div>
                        <input type="hidden" title="Please verify this" class="required" name="keycode" id="keycode">

                        <div id="cap-response" style="display:none; color:#F00;"></div>
                    </div>
                </div>
                <button type="submit" class="btn-2">Subscribe</button>
            </form>

        </div>
        @if($page->slug=='about-us' && !Auth::check())
            <div class="box-1">
                <div class="container">
                    <div class="tb-col break-991">
                        <div class="col">
                            <h3>Get Access to our Regulatory Updates, Country Information and Resources with Regulatory
                                Hub Subscription</h3>
                        </div>
                        <div class="col">
                            <a class="btn-3" href="register.html">REGISTER NOW!</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div><!-- //main -->


@endsection
@push('scripts')
<script>
    $("input:checkbox").click(function () {
        var checkboxgroup = "input:checkbox[name='" + $(this).attr("name") + "']";
        $(checkboxgroup).attr("checked", false);
        $(this).attr("checked", true);
        $("." + $(this).attr("id")).click();
    });

</script>
@endpush
