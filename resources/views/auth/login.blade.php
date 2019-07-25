@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
        <div class="main-wrap">
            @include('inc.banner')
            <div class="container space-1">
                @include('admin.inc.message')
                <form action="{{ route('login') }}" method="POST" class="form-wrap-1 form-type form-ani">
                    @csrf
                    <h1 class="title-1 text-center">Sign in to your account</h1>
                    <div class="inrow">
                        <span><input type="text" class="form-control @if ($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" /></span>
                        <label>Email Address</label>
                        {{-- @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif --}}
                    </div>
                    <div class="inrow">
                        <span><input type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" name="password" /></span>
                        <label>Password</label>
                        {{-- @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif --}}
                    </div>
                    <input type="hidden" name="redirect" value="@if(isset($_GET['type'])) @if($_GET['type']=='login') {{ url($_GET['page']) }} @endif @endif">
                    <div class="form-group">
                            <div class="google-recaptcha">
                                <div class="g-recaptcha" data-callback="onSubmit"
                                    data-sitekey="6Lf7LawUAAAAAF81NXrWPmOJ3HmDXwRZfDCsURC3" data-size="invisible"></div>
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
            <div class="box-1">
                <div class="container">
                    <div class="tb-col break-991">
                        <div class="col">
                            <h3>Not Registered With Us?</h3>
                            <p>Join us and gain access to all our benefits today.</p>
                        </div>
                        <div class="col">
                            <a class="btn-3" href="{{ url('register') }}">GET IT NOW!</a>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- //main -->

    </div><!-- //page -->
@endsection
